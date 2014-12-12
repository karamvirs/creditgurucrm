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

class XMLManager {

	private static $sent = false;

	function __construct ($noHeader = false) {

		if ($noHeader || self::$sent) return;

		@ob_end_clean();
		@ob_end_clean();
		@ob_end_clean();

		header('Content-type: text/xml');
		echo "<?xml version='1.0' encoding='utf-8'?".">\n";

		self::$sent = true;
	}

	public function _array2xml ($array, $level = 1, $forceKey = '') {
		
		$xml = '';
		
		foreach ($array as $key => $value) {
			
			$key = $forceKey ? $forceKey : strtolower($key);

			if (is_object($value)) {
				$value = get_object_vars($value);
			}
			
			if (is_array($value)) {
				$skey = array_keys($value);
				sort($skey);
				if ($skey === range(0, count($value) -1)) {
					$xml .= $this->_array2xml($value, $level, $key);
				}
				else {
					$xml .= str_repeat("\t", $level) . "<$key>\n";
					$xml .= $this->_array2xml($value, $level +1);
					$xml .= str_repeat("\t", $level) . "</$key>\n";
				}
		  
			} else {
				if (htmlspecialchars($value) != $value) {
					$xml .= str_repeat("\t", $level) . "<$key><![CDATA[$value]]></$key>\n";
				} else {
					$xml .= str_repeat("\t", $level) . "<$key>$value</$key>\n";
				}
			}
		}
		return $xml;
	}

	public function array2xml ($array) {

		$xml = '';

		$xml .= "<rows>\n";
		$xml .= $this->_array2xml($array);
		$xml .= "</rows>\n";

		return $xml;
	}

	public function cdata ($text) {

		return htmlspecialchars($text) != $text ? "<![CDATA[$text]]>" : $text;
	}

}
?>
