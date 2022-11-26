<?php

namespace Physler\Controller\Api;

use ScssPhp\ScssPhp\Compiler as ScssCompiler;

class RenderController extends BaseController {
    public function css() {
        @$env = $this->getQuery()["env"];
        @$name = $this->getQuery()["name"];
        @$outputType = $this->getQuery()["output_type"];

        $this->appendHeaders("Content-Type: text/css");

        $_env = "";
        switch ($env) {
            case "app":
                $_env = "/common/app/";                
                break;
        }

        $path = __ROOT__."/".$_env.$name;

        if (file_exists($path) && is_file($path)) {
            $compiler = new ScssCompiler();
            $outputstyle = (isset($outputType) ? $outputType : "compressed");
            $compiler->setOutputStyle($outputstyle);
            $year = date("Y");
            $data = "/** PhysiRec & PhyslerFramework (c) $year\n *  https://github.com/hellokoda/PhysiRec/LICENSE.md\n *  \n *\n *  Rendered from Sass to CSS by https://github.com/scssphp/scssphp\n *  https://github.com/scssphp/scssphp/blob/master/LICENSE.md\n **/\n\n".$compiler->compileString(file_get_contents($path))->getCss() . "\n\n";
            $this->output($data);
        } else {
            $this->output("/** No sheets found **/");
        }

        return;
    }
}