<?php
/**
 * QRCode Plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Ben van Magill <ben.vanmagill16@gmail.com>
 * @author     Daniel Pätzold <mailto://obel1x@web.de>
 */


if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
require_once(DOKU_INC.'inc/search.php');
require_once(DOKU_INC.'conf/dokuwiki.php');
    
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_qrcodephp extends DokuWiki_Syntax_Plugin {

    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }

    /**
     * What about paragraphs?
     */
    function getPType(){
        return 'block';
    }

    /**
     * Where to sort in?
     */
    function getSort(){
        return 319;
    }


    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{\s?QRCODE(?:\s\d{1,}|)>[^}]*\}\}',$mode,'plugin_qrcodephp');
    }


    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler){
        // Strip the opening and closing markup
        $match = preg_replace(array('/^\{\{/','/\}\}$/u'),'',$match);
        $ralign = (bool)preg_match('/^ /',$match);
        $lalign = (bool)preg_match('/ $/',$match);

        // trim any spaces
        $match = trim($match);

        // Split title from URL
        list($params, $qr) = explode('>',$match,2);
        list($_, $ppp) = explode(' ', $params, 2);

        // ppp=pixel per point to default
        if (!$ppp) $ppp = 4;
        // Check alignment
        
        if ( $lalign & $ralign ) {
        $align = 'center';
        } else if ( $ralign ) {
        $align = 'right';
        } else if ( $lalign ) {
        $align = 'left';
        } else {
        $align = null;
        }

        $data['qr'] = urlencode($qr);
        $data['align'] = $align;
        $data['ppp'] = $ppp;

        return $data;
        }

    /**
     * Create output
     */
    public function render($mode, Doku_Renderer $renderer, $data) {
		
        // $data is what the function handle return'ed.
        if($mode == 'xhtml'){
            /** @var Doku_Renderer_xhtml $renderer */
			
			$out = '<img class="media'.$data['align'].'" '; 
            $out .= 'src="'.DOKU_BASE.'lib/plugins/qrcodephp/png.php?id='.$data['qr'].'&ppp='.$data['ppp'].'" />';
			
            $renderer->doc .= $out;
            return true;
        }
        return false;
    }
}

//Setup VIM: ex: et ts=4 enc=utf-8 :
