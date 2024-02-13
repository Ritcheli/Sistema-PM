import fitz
import glob
import os
import json
from fitz import Rect

def main():
    text          = ''
    ocorrencia    = []
    bool_no_files = True;

    list_Path = glob.glob("C:\\Users\\Ritcheli\\Documents\\UFSC\\2022-2\\TCC\\Sistema-PM\\public\\uploads\\pdf\\*.pdf")

    # list_Path = glob.glob("C:\\Users\\Ritcheli\\Documents\\UFSC\\2022-2\\TCC\\Python-Extraction-PDF\\importacao\\VINICIUSSADIMARQUES-PROTOCOLO8960927.pdf")

    for k in range(0, len(list_Path)):
        if ('(inserted)' not in list_Path[k]):
            bool_no_files = False

            text           = ''
            aux_fato       = ''
            aux_nome_3     = {}
            words          = {}
            outras_info    = {}
            endereco       = {}
            nome_envolvido = {}
            participacao   = {}
            envolvidos     = []
            objetos        = [] 
            drogas         = []
            veiculos       = []
            armas          = []
            animais        = []
            aux_nome_1     = []
            aux_2          = []

            doc = fitz.open(list_Path[k])

            i = 0;

            page_for_serch = doc[0]

            if (len(page_for_serch.search_for("backend.ssp")) > 0):
                rect = Rect(60, 25, 580, 815)
                opcao_1 = True
            if (len(page_for_serch.search_for("sade.pm.sc.gov")) > 0):
                opcao_1 = False
            else:
                rect = Rect(60, 90, 580, 805)
                opcao_1 = True

            str_Antigo_nome = list_Path[k]
            str_Novo_Nome   = list_Path[k].replace('.pdf', '(inserted).pdf')
            str_Novo_Nome   = str_Novo_Nome.replace(' ', '')

            if (opcao_1 == True):
                for page in doc: 
                    text += str(page.get_text("text", rect, sort = True)) 
                    words['page' + str(i)] = page.get_text("words", clip = [60, 90, 580, 805])
                    i += 1

                doc.close()
                
                #Extração dos fatos e nomes de envolvidos
                aux_1 = ''
                aux_2 = ''

                text = " ".join(text.split())

                for i in range(len(words)):
                    for word in words['page' + str(i)]:
                        if (word[4] == 'COMUNICADOS:'):
                            aux_1 = word
                        if (word[4] == 'ENVOLVIDOS'):
                            if (len(aux_2) == 0):
                                aux_2 = word
                        if (word[4] == 'anos)'):
                            aux_nome_1.append({'palavra' : word,
                                               'pag' : i})

                idx_atendente = text.find("ATENDENTES")

                # Verifica se existem envolvidos relacionados a ocorrencia
                if (text.find("ENVOLVIDOS", 0, idx_atendente) != -1):         
                    #Inicializa o vetor de nomes
                    for i in range(len(aux_nome_1)):
                        aux_nome_3['nome' + str(i)] = ""
                    
                    for word in words['page0']:
                        if ((word[1] >= aux_1[1]) and (word[1] < aux_2[1])):
                            aux_fato += word[4] + " "   
                    
                    # For para percorrer todas as páginas de palavras
                    for i in range(len(words)):
                        # For para percorrer todas as palavras em determinada página
                        for word in words['page' + str(i)]:
                            # For para percorrer todos os nomes existentes
                            for j in range(len(aux_nome_1)):
                                # Verifica se a página atual é a que contem os nomes
                                if (aux_nome_1[j]['pag'] == i):
                                    if ((word[1] == aux_nome_1[j]['palavra'][1])):
                                        aux_nome_3['nome' + str(j)] += " " + word[4] + " "

                    #Faz a separação de todos os fatos da ocorrência
                    if ('OUTROS DADOS:' in aux_fato):
                        aux_fato = get_General_Data_Between("", "OUTROS DADOS:", aux_fato)

                    fatos = []
                    fatos = (aux_fato[19:].split(';'))
                    
                    #Faz a separação do nome dos envolvidos
                    for i in range(len(aux_nome_1)):
                        nome_envolvido['nome' + str(i)] = " ".join((get_General_Data("", "(", aux_nome_3['nome' + str(i)])).split())
                        participacao['participacao' + str(i)] = get_General_Data(nome_envolvido['nome' + str(i)], "Mãe:", text)

                    #Extração do restante das informações dos envolvidos
                    aux_envolvidos = get_General_Data("ENVOLVIDOS", "ATENDENTES", text)
                    num_envolvidos = aux_envolvidos.count('Mãe:')

                    for i in range(num_envolvidos):
                        rg  = get_General_Data("RG:", "-", aux_envolvidos)
                        cpf = get_General_Data("RG: Não informado", "CPF:", aux_envolvidos)
                        naturalidade = get_General_Data("Naturalidade:", "BRASIL", aux_envolvidos)
                        estado = naturalidade[len(naturalidade) - 3:].strip('/')

                        if (len(rg) > 12):
                            rg = "";
                        if (len(cpf) > 15):
                            cpf = ""
                        if (len(estado) > 2):
                            estado = ""
                        
                        rg  = rg.replace('.', '').replace('-', '')
                        cpf = cpf.replace('.', '').replace('-', '')

                        envolvidos.append({'nome': nome_envolvido['nome' + str(i)],
                                        'participacao': participacao['participacao' + str(i)],
                                        'data_nascimento' : get_General_Data("Data de Nascimento:", "Naturalidade:", aux_envolvidos),
                                        'RG' : rg,
                                        'CPF': cpf,
                                        'estado': estado})

                        aux_envolvidos_1 = get_General_Data_Strip("", "Individual:", aux_envolvidos)

                        aux_envolvidos = aux_envolvidos.replace(aux_envolvidos_1, '') 
                else:
                    idx_bens_objetos = text.find("BENS/OBJETOS", 0, idx_atendente)

                    if (idx_bens_objetos != -1):
                        fatos = (get_General_Data("FATOS COMUNICADOS:", "BENS/OBJETOS", text)).split(";")
                    else:
                        fatos = (get_General_Data("FATOS COMUNICADOS:", "ATENDENTES", text)).split(";")

                #Extração do endereço
                endereco_extraido = get_General_Data("LOCAL", "FATOS COMUNICADOS:", text)
                endereco_extraido = get_General_Data("FATO:", "FATOS COMUNICADOS:", endereco_extraido).split(',')
                
                endereco_rua    = endereco_extraido[0].strip()
                endereco_num    = endereco_extraido[1].strip()
                endereco_bairro = endereco_extraido[2].strip()
                endereco_cidade = endereco_extraido[3].split('/')[0].strip()
                endereco_estado = endereco_extraido[3].split('/')[1].strip()
                endereco_cep    = endereco_extraido[3].split('/')[2].split('|')[1].strip('CEP: ')

                if (len(endereco_cep) > 9):
                    endereco_cep = ""

                endereco['endereco_rua']    = endereco_rua
                endereco['endereco_num']    = endereco_num.replace("\n", ' ')
                endereco['endereco_bairro'] = endereco_bairro.replace("\n", ' ')
                endereco['endereco_cidade'] = endereco_cidade.replace("\n", ' ')
                endereco['endereco_estado'] = endereco_estado
                endereco['endereco_cep']    = endereco_cep     

                itens = get_General_Data("BENS/OBJETOS", "ATENDENTES", text)

                num_itens = (itens.count("▪"))

                for i in range(num_itens):
                    item = (get_General_Data("", "▪", itens[1:]))

                    itens = (itens.replace("▪ " + item, '')).strip()

                    if (get_Items_Data("", "-", item) == "Objeto"): 
                        qtd_un_med_obj = get_General_Data('Quantidade:', '|', item)
                        modelo         = get_General_Data('Modelo:', '▪', item)
                        n_serie        = modelo
                        obs_obj        = modelo

                        modelo = get_Items_Data('', '|', modelo)

                        if ('\n' in modelo):
                            modelo = get_Items_Data('', '\n', modelo)
                        
                        if ('Nº de série:' in n_serie):
                            n_serie    = get_General_Data('Nº de série:', '▪', item)
                        else: 
                            n_serie = "" 
                        
                        if ('informações:' in obs_obj):
                            obs_obj = get_General_Data('informações:', '▪', obs_obj) 
                        else:
                            obs_obj = ""

                        objetos.append({'tipo'       : get_General_Data('-', '(', item),
                                        'quantidade' : qtd_un_med_obj.split(' ')[0].replace(',', '.'),
                                        'un_med'     : qtd_un_med_obj.split(' ')[1],
                                        'marca'      : get_General_Data('Marca:', 'Modelo:', item)[:-2],
                                        'modelo'     : modelo,
                                        'num_serie'  : get_Items_Data('', '|', n_serie),
                                        'outras_info': get_Items_Data('', '\n', obs_obj)})

                    if (get_Items_Data("", "-", item) == "Substância com características semelhantes a"):
                        qtd_un_med_droga_aux = get_General_Data('Quantidade aproximada:', '▪', item)
                        qtd_un_med_droga_aux = get_Items_Data('', ')', qtd_un_med_droga_aux)
                        qtd_un_med_droga     = qtd_un_med_droga_aux.split(" ")

                        drogas.append({'tipo'      : get_General_Data('-', '(', item),
                                       'quantidade': qtd_un_med_droga[0].replace(',', '.'),
                                       'un_medida' : qtd_un_med_droga[2][1:]})

                    if (get_Items_Data("", "-", item) == "Veículo licenciado no Brasil"):
                        chassi    = get_General_Data('Chassi:', '▪', item)
                        renavam   = get_General_Data('Renavam:', '▪', item)

                        marca_cor_Aux = get_Items_Data('\n', '▪', renavam)
                        marca_cor_Aux = get_Items_Data('', '\n', marca_cor_Aux)

                        marca_cor = marca_cor_Aux.split('-')

                        veiculos.append({'placa'  : get_General_Data('Placa:', '|', item),
                                         'chassi' : get_Items_Data('', '|', chassi),
                                         'renavam': get_Items_Data('', '\n', renavam),
                                         'marca'  : marca_cor[0].strip(),
                                         'cor'    : marca_cor[1].strip()})
                    
                    if (get_Items_Data("", "-", item) == "Arma de fogo"):
                        calibre   = get_General_Data('Calibre real:', '▪', item)
                        num_serie = get_General_Data('Nº de série:', '▪', item)

                        armas.append({'tipo'     : get_General_Data('-', '(', item),
                                      'especie'  : get_General_Data('Marca:', '|', item),
                                      'calibre'  : get_Items_Data('', '|', calibre), 
                                      'num_serie': get_Items_Data('', '\n', num_serie)})

                descricao_ocorrencia = get_General_Data('ATENDENTES', 'PROVIDÊNCIAS', text)

                if (len(envolvidos) > 0):
                    outras_info['envolvidos'] = 'S'
                else:
                    outras_info['envolvidos'] = 'N'

                if (len(veiculos) > 0):
                    outras_info['veiculos'] = 'S'
                else:
                    outras_info['veiculos'] = 'N'

                if (len(armas) > 0):
                    outras_info['armas'] = 'S'
                else:
                    outras_info['armas'] = 'N'

                if (len(drogas) > 0):
                    outras_info['drogas'] = 'S'
                else:
                    outras_info['drogas'] = 'N' 

                if (len(objetos) > 0):
                    outras_info['objetos'] = 'S'
                else:
                    outras_info['objetos'] = 'N'

                if (len(animais) > 0):
                    outras_info['animais'] = 'S'
                else:
                    outras_info['animais'] = 'N'

                num_protocol = get_General_Data("PROTOCOLO SADE No", "B", text)

                ocorrencia.append({'num_protocol'     : num_protocol,
                                   'data_hora'        : get_General_Data("DATA DO FATO:", "HORA DO FATO:", text) + " " + get_General_Data("HORA DO FATO:", "LOCAL", text) + ":00",
                                   'endereco'         : endereco,
                                   'grupos'           : '',
                                   'fatos'            : fatos,
                                   'possui_envolvidos': outras_info['envolvidos'],
                                   'envolvidos'       : envolvidos,
                                   'possui_objetos'   : outras_info['objetos'],
                                   'objetos'          : objetos,
                                   'possui_drogas'    : outras_info['drogas'],
                                   'drogas'           : drogas,
                                   'possui_veiculos'  : outras_info['veiculos'], 
                                   'veiculos'         : veiculos,
                                   'possui_armas'     : outras_info['armas'],
                                   'armas'            : armas,
                                   'possui_animais'   : outras_info['animais'],
                                   'animais'          : animais,
                                   'desc_inicial'     : '',
                                   'descricao'        : descricao_ocorrencia,
                                   'PDF_original'     : str_Novo_Nome})
            else:
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

                fatos = []
                fatos.append(get_General_Data('Fato:', 'Descrição inicial do fato:', text))

                endereco['endereco_rua']    = ""
                endereco['endereco_num']    = ""
                endereco['endereco_bairro'] = ""
                endereco['endereco_cidade'] = ""
                endereco['endereco_estado'] = ""
                endereco['endereco_cep']    = ""

                ocorrencia.append({ 'num_protocol'     : get_General_Data('Ocorrência Protocolo:', '[', text),
                                    'data_hora'        : get_General_Data('[', ']', get_General_Data('Ocorrência Protocolo:', 'Localização', text)),
                                    'endereco'         : endereco,
                                    'grupos'           : get_General_Data('Grupo:', 'Agência(s):', text), 
                                    'fatos'            : fatos,
                                    'desc_inicial'     : get_General_Data('Descrição inicial do fato:', 'Registrado por:', text),
                                    'descricao'        : get_General_Data('Relato policial do Ocorrido:', 'Finalizado por:', text),
                                    'possui_envolvidos': outras_info['envolvidos'],
                                    'envolvidos'       : envolvidos,
                                    'possui_objetos'   : outras_info['objetos'],
                                    'objetos'          : objetos,
                                    'possui_drogas'    : outras_info['drogas'],
                                    'drogas'           : drogas,
                                    'possui_veiculos'  : outras_info['veiculos'], 
                                    'veiculos'         : veiculos,
                                    'possui_armas'     : outras_info['armas'],
                                    'armas'            : armas,
                                    'possui_animais'   : outras_info['animais'],
                                    'animais'          : animais,
                                    'PDF_original'     : str_Novo_Nome})
                
                text = "";

            os.rename(str_Antigo_nome, str_Novo_Nome)

    if (bool_no_files == False):
        print(json.dumps(ocorrencia))

def get_General_Data(str_Init_Word, str_End_Word, str_Text):
    Idx_Init = str_Text.find(str_Init_Word)
    Idx_End  = str_Text.find(str_End_Word, Idx_Init)

    Data = str_Text[Idx_Init + len(str_Init_Word) + 1: Idx_End]

    return Data.strip()

def get_General_Data_Between(str_Init_Word, str_End_Word, str_Text):
    Idx_Init = str_Text.find(str_Init_Word)
    Idx_End  = str_Text.find(str_End_Word, Idx_Init)

    Data = str_Text[Idx_Init + len(str_Init_Word): Idx_End]

    return Data.strip()

def get_General_Data_Strip(str_Init_Word, str_End_Word, str_Text):
    Idx_Init = str_Text.find(str_Init_Word)
    Idx_End  = str_Text.find(str_End_Word, Idx_Init)

    Data = str_Text[Idx_Init + len(str_Init_Word) + 1: Idx_End + len(str_End_Word)]

    return Data.strip()

def get_Items_Data(str_Init_Word, str_End_Word, str_Text):
    Idx_Init = str_Text.find(str_Init_Word)
    Idx_End  = str_Text.find(str_End_Word, Idx_Init)

    Data = str_Text[Idx_Init + len(str_Init_Word): Idx_End + len(str_End_Word) - 1]

    return Data.strip()

if __name__ == "__main__":
    main()