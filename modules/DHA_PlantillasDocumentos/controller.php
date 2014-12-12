<?php

require_once('include/MVC/Controller/SugarController.php');
  
class DHA_PlantillasDocumentosController extends SugarController {

   ///////////////////////////////////////////////////////////////////////////
   function action_editview(){
      $this->view = 'edit';
      $GLOBALS['view'] = $this->view;
      
      // Nota: para que aparezca el boton de "Quitar" en el editview (y por lo tanto funcione lo siguiente), hay que
      //       quitar la propiedad 'noChange' del vardef del campo "uploadfile" (que es de tipo file)
      if(!empty($_REQUEST['deleteAttachment'])){
         ob_clean();
         //echo $this->bean->deleteAttachment($_REQUEST['isDuplicate']) ? 'true' : 'false';
         echo $this->bean->BorraArchivoPlantilla($this->bean->id) ? 'true' : 'false';
         sugar_cleanup(true);
      }
   }
   
   ///////////////////////////////////////////////////////////////////////////
   function action_download(){

      $this->view = '';
      $GLOBALS['view'] = '';

      require_once('modules/DHA_PlantillasDocumentos/download_template.php');
   } 

   ///////////////////////////////////////////////////////////////////////////   
   function action_Configuration(){
      if(is_admin($GLOBALS['current_user'])) {
         $this->view = 'config';
         $GLOBALS['view'] = $this->view;    
      }
      else {
         //sugar_die("Unauthorized access to administration");
         sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']); 
      }
      return true;
   }     
   
   ///////////////////////////////////////////////////////////////////////////
   function action_generatedocument(){
      // Ver la funcion action_massupdate en include\MVC\Controller\SugarController.php
      // Esta accion ser� llamada tanto desde el listview (como si fuera un massupdate) como desde el detailview (con un boton)
      
      // Si no se anula la vista por defecto, devuelve tambien el html de una vista (supongo que la que est� por defecto), y no es lo que se requiere aqui
      $this->view = '';
      $GLOBALS['view'] = '';      

      $bean = SugarModule::get($_REQUEST['moduloplantilladocumento'])->loadBean();
      
      if(!$bean->ACLAccess('detail')){
         ACLController::displayNoAccess(true);
         sugar_cleanup(true);
      }

      set_time_limit(0);
      $GLOBALS['db']->setQueryLimit(0);

      require_once('modules/DHA_PlantillasDocumentos/MassGenerateDocument.php');
      $massDoc = new MassGenerateDocument();      
      $massDoc->setSugarBean($bean);
      $massDoc->handleMassGenerateDocument();
   }   
   
   ///////////////////////////////////////////////////////////////////////////
   function action_varlist(){

      // Se ha creado una vista nueva. Ver modules\DHA_PlantillasDocumentos\views\view.varlist.php
      $this->view = 'varlist';
      $GLOBALS['view'] = $this->view;      
   }

   ///////////////////////////////////////////////////////////////////////////
   function action_modulevarlist(){

      $this->view = '';
      $GLOBALS['view'] = '';

      require_once('modules/DHA_PlantillasDocumentos/Generate_Document.php');
      $GD = new Generate_Document($_REQUEST['moduloPlantilla'], NULL, NULL);  
      $GD->ObtenerHtmlListaVariables();
   }

   ///////////////////////////////////////////////////////////////////////////
   function action_crearplantillabasica(){
   
      require_once('modules/DHA_PlantillasDocumentos/Generate_Document.php');
      $GD = new Generate_Document($_REQUEST['moduloPlantilla'], NULL, NULL);
      $GD->CrearPlantillaBasica();
   }   
   
   ///////////////////////////////////////////////////////////////////////////   
   public function action_saveconfig(){
      require_once('include/utils.php');
      require_once('modules/DHA_PlantillasDocumentos/UI_Hooks.php');

      global $app_strings, $current_user, $moduleList, $sugar_config;
      
      $this->view = '';
      $GLOBALS['view'] = '';      

      if (!is_admin($current_user)) 
         sugar_die($app_strings['ERR_NOT_ADMIN']);

      require_once('modules/Configurator/Configurator.php');
      $configurator = new Configurator();
      $configurator->loadConfig();  // no es necesario
      
      
      if (isset($_REQUEST['enabled_modules'])) {
         $DHA_templates_historical_enabled_modules = array();
         $enabled_modules = array ();         
         foreach ( explode (',', $_REQUEST['enabled_modules'] ) as $module_name ) {
            $enabled_modules [$module_name] = $module_name;
         }
         
         $modules = MailMergeReports_get_all_modules();
         $disabled_modules = array();
         foreach ( $modules as $module_name => $def) {
            if (!isset($enabled_modules[$module_name])) {
               $disabled_modules[$module_name] = $module_name;
            }
         }

         foreach ($disabled_modules as $module_name) {
            MailMergeReports_after_ui_frame_hook_module_remove($module_name);
            $DHA_templates_historical_enabled_modules[$module_name] = false;
         }
         foreach ($enabled_modules as $module_name) {
            MailMergeReports_after_ui_frame_hook_module_install($module_name);
            $DHA_templates_historical_enabled_modules[$module_name] = true;
         } 

         // Guardamos hist�rico de los m�dulos habilitados (esto solo sirve para el instalador del componente, para que recupere los modulos habilitados en caso de reinstalacion)
         $configurator->config['DHA_templates_historical_enabled_modules'] = $DHA_templates_historical_enabled_modules;        
      }
      
      if ( isset( $_REQUEST['templates_roles_enabled_levels'] ) && isset( $_REQUEST['templates_roles_enabled_levels_ids'] )) {
         $DHA_templates_enabled_roles = array();
         $role_ids = explode (',', $_REQUEST['templates_roles_enabled_levels_ids']);
         $role_levels = explode (',', $_REQUEST['templates_roles_enabled_levels']);
         
         foreach($role_ids as $key => $value) {
            $DHA_templates_enabled_roles[$value] = $role_levels[$key];
         } 
         
         $configurator->config['DHA_templates_enabled_roles'] = $DHA_templates_enabled_roles;         
      }      
      
      $configurator->saveConfig();
      
      echo "true";
   }    
   
}
?>
