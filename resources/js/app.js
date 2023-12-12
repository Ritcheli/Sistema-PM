// CDN
import 'https://cdn.ckeditor.com/ckeditor5/37.1.0/super-build/ckeditor.js';

// Node modules
import 'bootstrap';
import $ from 'jquery';
import 's-pagination';
import 'pdfobject';
import 'jspdf'; // Revisar essa biblioteca

// Pages
import './pages/ocorrencia';
import './pages/busca_ocorrencia';
import './pages/pessoa';
import './pages/busca_pessoa';
import './pages/importar_ocorrencia';
import './pages/revisar_ocorrencia';
import './pages/dashboard';
import './pages/analise_ocorrencia';
import './pages/configuracao';

// Vendors
import './vendors-extensions/bootstrap';

// Components
import './components/sidebar';
import './components/input_img_file';
import './components/modal_pessoa';
import './components/modal_busca_pessoa';
import './components/modal_veiculo';
import './components/modal_busca_veiculo';
import './components/data_range';
import './components/input_files_component';
import './components/custom-selection';
import './components/tables';
import './components/form_droga';
import './components/form_animal';
import './components/form_objeto_diverso';
import './components/form_arma';
import './components/virtual-select.min';

window.jQuery = window.$ = $;
