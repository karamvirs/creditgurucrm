<?php


/*******************************************************************************
 * This file is integral part of the project "Installer for Dispage Extension
 * Manager" for SugarCRM.
 * 
 * "Installer for Dispage Extension Manager" is a project created by: 
 * Dispage - Patrizio Gelosi
 * Via A. De Gasperi 91 
 * P. Potenza Picena (MC) - Italy
 * 
 * (Hereby referred to as "DISPAGE")
 * 
 * Copyright (c) 2010-2012 DISPAGE.
 * 
 * The contents of this file are released under the GNU General Public License
 * version 3 as published by the Free Software Foundation that can be found on
 * the "LICENSE.txt" file which is integral part of the SUGARCRM(TM) project. If
 * the file is not present, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You may not use the present file except in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied.  See the License
 * for the specific language governing rights and limitations under the
 * License.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * Dispage" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by Dispage".
 * 
 ******************************************************************************/

/*********************************************************************************
 * 

 *********************************************************************************
 * Title: FilePreserve.php
 * Version: 2.1.4
 * Description:  The file contains the main File Preservation Class
 ********************************************************************************/

class FilePreserve {

    var $start_string;
    var $end_string;
    var $start_string_regexp;

    var $id_string;
    var $id_name;
    var $source_dir;
    var $base_dir;
    var $version_1_mode;
    var $ignore_modulename = false;


    function FilePreserve ($params) {

        global $_POST, $_SERVER;

        if (@$params['id_name'])
            $this->id_name = @$params['id_name'];
        else
            $this->id_name = $_POST['id_name'];

        $id_version = @$params['id_version'] ? @$params['id_version'] : @$_POST['version'];

		$this->version_1_mode = @$params['version_1_mode'];
		if ($this->version_1_mode) {
			$this->id_string = "$this->id_name $id_version";
		}
		else {
			$this->id_string = $this->id_name;
		}
		if (isset($params['ignore_modulename'])) {
			$this->ignore_modulename = $params['ignore_modulename'];
		}
        $this->source_dir = @$params['source_dir'] ? @$params['source_dir'] : preg_replace('#[\\\\/]+#', '/', @$_POST['source_dir']);
        $this->base_dir = @$params['base_dir'] ? @$params['base_dir'] : preg_replace('#^(.*)[\\\\/]+[^\\\\/]+$#', '\\1', $_SERVER['SCRIPT_FILENAME']);
        $this->uninstall = @$params['uninstall'];
    }

    function assignBoundaryStrings($is_template, $ind) {

        if ($is_template) {
            $start_comment = '{';
            $end_comment = '}';
            $start_regex_comment = '\{';
            $end_regex_comment = '\}';
        }
        else
            $start_comment = $end_comment = $start_regex_comment = $end_regex_comment = '/';

        $insert_id = $ind !== '' ? "::$ind::": "";

        $this->start_string = "$start_comment* BEGIN $this->id_string $insert_id *$end_comment";
        $this->end_string = "$start_comment* END $this->id_string $insert_id *$end_comment";
		$modulename = $this->ignore_modulename ? '[^*]*?' : $this->id_name;
		$begin_id = $insert_id ? '\s*?' . $insert_id : '.*?';
		$this->start_string_regexp = "$start_regex_comment\* BEGIN ($modulename(?>$begin_id \*$end_regex_comment))";

        return $start_regex_comment;
    }

    function addContent($file_path, $parameters = array('' => array())) {

		if (!$parameters && !$this->uninstall) return;

        $is_template = preg_match('/\.tpl$/', $file_path);

        if (file_exists($this->base_dir . $file_path)) {

            $old_content = file_get_contents($this->base_dir . $file_path);

            foreach ($parameters as $ind => $params) {

                $old_versions_code_regexp = isset($params['regexp']) ? preg_replace('/[\r\n]+\\\\s\*|\\\\s\*[\r\n]+/', '\s*', $params['regexp']) : '';
                $maintain = isset($params['maintain']) ? $params['maintain'] : '\\1';
                $file_content = isset($params['content']) ? $params['content'] : '';
                $put_back = isset($params['put_back']) ? $params['put_back'] : false;
                $add_bottom = isset($params['add_bottom']) ? $params['add_bottom'] : false;
                $skip_error = isset($params['skip_error']) ? $params['skip_error'] : false;
				if ($this->uninstall) {
					$rx_limit = -1;
				}
				else {
	                $rx_limit = @$params['rx_limit'] ? $params['rx_limit'] : 1;
				}
                $rx_offset = isset($params['rx_offset']) ? $params['rx_offset'] : '';

                $start_regex_comment = $this->assignBoundaryStrings($is_template, $ind);

                if (!$file_content && !$this->uninstall)
                    $file_content = file_get_contents($this->source_dir . $file_path);

                $es_content = "$this->start_string\n$file_content$this->end_string";

                if (preg_match("#$this->start_string_regexp(?>.*?$start_regex_comment\* END \\1)#s", $old_content)) {
                    if ($this->uninstall)
                        $es_content = preg_replace("#$this->start_string_regexp(?>.*?$start_regex_comment\* END \\1)#s", $file_content, $old_content, $rx_limit);
                    else
                        $es_content = preg_replace("#$this->start_string_regexp(?>.*?$start_regex_comment\* END \\1)#s", $es_content, $old_content, $rx_limit);
                }
                elseif ($this->uninstall) {
					$es_content = $old_content;
                    continue;
				}
                elseif ($old_versions_code_regexp && preg_match("#$old_versions_code_regexp#s", $old_content)) {
                    $replace_str = strpos($maintain, '$es_content') === false ? ($put_back ? "\n$es_content $maintain\n" : "\n$maintain $es_content\n") : eval("return \"$maintain\";");
                    $es_content = preg_replace("#$old_versions_code_regexp#s", $replace_str, $old_content, $rx_limit);
                }
                elseif ($add_bottom)
                    $es_content = rtrim(str_ireplace(array('<?php', '?>'), array(), $old_content)) . "\n\n". $es_content;
                elseif ($skip_error)
                    $es_content = $old_content;
                else
                    $this->stopInstallation("#0100 - Error during Installation : Unable to patch '$file_path' ($ind)");

                $old_content = $es_content;
            }
        }
        elseif (!$this->uninstall) {
			$path_dir = dirname($this->base_dir . $file_path);
			if (!is_dir($path_dir)) {
				mkdir_recursive($path_dir, true);
			}
            touch($this->base_dir . $file_path);

			$file_content = '';
			$add_bottom = false;

            foreach ($parameters as $ind => $params) {

                $file_content .= @$params['content'];
                $add_bottom |= isset($params['add_bottom']) ? $params['add_bottom'] : false;
			}
            $this->assignBoundaryStrings($is_template, $ind);

            if (!$file_content)
                $file_content = trim(preg_replace(array('/^[\r\n\t ]*<\?php/i', '/\?>[\r\n\t ]*$/i'), array(), file_get_contents($this->source_dir . $file_path)));

            $es_content = "$this->start_string\n$file_content$this->end_string";
        }
		else return;

        if ($add_bottom)
            $res_content = "\n".trim(str_ireplace(array('<?php', '?>'), array(), $es_content))."\n";
        else
            $res_content = "\n".trim(preg_replace(array('/^[\r\n\t ]*<\?php/i', '/\?>[\r\n\t ]*$/i'), array(), $es_content))."\n";

        if (!isset($is_template) || !$is_template)
            $res_content = "<?php$res_content?>";

        if (!file_put_contents($this->base_dir . $file_path, $res_content) && !$this->uninstall)
            $this->stopInstallation("#0101 Error during Installation : Unable to write into '$file_path'");

    }
    
    function stopInstallation ($msg) {
    
    	if (function_exists('pre_uninstall'))
    		pre_uninstall();
    	
    	die($msg);
    }
}

?>
