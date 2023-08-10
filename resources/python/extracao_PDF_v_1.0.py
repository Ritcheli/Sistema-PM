import fitz
import glob
import os
import json

def main():
    text = ''
    ocorrencia = []
    outras_info = {}
    bool_no_files = True;

    list_Path = glob.glob("C:\\Users\\Ritcheli\\Documents\\UFSC\\2022-2\\TCC\\Sistema-PM\\public\\uploads\\pdf\\*.pdf")

    for k in range(0, len(list_Path)):
        if ('(inserted)' not in list_Path[k]):
            bool_no_files = False

            doc = fitz.open(list_Path[k])

            for page in doc: 
                text += str(page.get_text("text", clip = [26, 26, 580, 810])) 

            doc.close()

            if (text.count("Nenhum envolvido nesta ocorrência.") == 0):
                outras_info['envolvidos'] = 'S'
            else:
                outras_info['envolvidos'] = 'N'

            if (text.count("Nenhum veículo envolvido nesta ocorrência.") == 0):
                outras_info['veiculos'] = 'S'
            else:
                outras_info['veiculos'] = 'N'

            if (text.count("Nenhuma arma envolvida nesta ocorrência.") == 0):
                outras_info['armas'] = 'S'
            else:
                outras_info['armas'] = 'N'

            if (text.count("Nenhuma droga envolvida nesta ocorrênciao.") == 0):
                outras_info['drogas'] = 'S'
            else:
                outras_info['drogas'] = 'N'

            if (text.count("Nenhum outro objeto envolvido nesta ocorrência.") == 0):
                outras_info['objetos'] = 'S'
            else:
                outras_info['objetos'] = 'N'

            if (text.count("Nenhum animal envolvido nesta ocorrência.") == 0):
                outras_info['animais'] = 'S'
            else:
                outras_info['animais'] = 'N'         

            str_Antigo_nome = list_Path[k]
            str_Novo_Nome   = list_Path[k].replace('.pdf', '(inserted).pdf')

            ocorrencia.append({ 'num_protocol' : get_General_Data('Ocorrência Protocolo:', '[', text),
                                'data_hora'    : get_General_Data('[', ']', get_General_Data('Ocorrência Protocolo:', 'Localização', text)),
                                'endereco'     : get_General_Data('Endereço:', 'Área de Despacho', text),
                                'grupo'        : get_General_Data('Grupo:', 'Agência(s):', text), 
                                'fato'         : get_General_Data('Fato:', 'Descrição inicial do fato:', text),
                                'desc_inicial' : get_General_Data('Descrição inicial do fato:', 'Registrado por:', text),
                                'descricao'    : get_General_Data('Relato policial do Ocorrido:', 'Finalizado por:', text),
                                'envolvidos'   : outras_info['envolvidos'],
                                'veiculos'     : outras_info['veiculos'],
                                'armas'        : outras_info['armas'],
                                'drogas'       : outras_info['drogas'],
                                'objetos'      : outras_info['objetos'],
                                'animais'      : outras_info['animais'],
                                'PDF_original' : str_Novo_Nome})
            
            text = "";

            os.rename(str_Antigo_nome, str_Novo_Nome)

    if (bool_no_files == False):
        print(json.dumps(ocorrencia))

def get_General_Data(str_Init_Word, str_End_Word, str_Text):
    Idx_Init = str_Text.find(str_Init_Word)
    Idx_End  = str_Text.find(str_End_Word)

    Data = str_Text[Idx_Init + len(str_Init_Word) + 1: Idx_End]

    return Data.strip()

if __name__ == "__main__":
    main()