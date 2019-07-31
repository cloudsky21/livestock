<?php

namespace Classes;

class html
{
    /*
    @param $header = Title of Page
    @param styleSheet = CSS stylesheet
     */

    private $icon = "./images/favicon.ico";
    private $title = "| Livestock Control";
    private $styleSheet = array(
        "./resources/bootswatch/cyborg/bootstrap.css",
    );

    public function __construct()
    {

    }
    public function favIcon($icon)
    {
        /*use and SET private $icon variable*/
        $this->icon = $icon;
    }
    public function SetIcon()
    {
        /* Return Icon */
        return $this->icon;
    }
    public function pageTitle($title)
    {
        /* use and SET private $title variable */
        $this->title = $title;

    }
    public function SetPageTitle()
    {
        /* Return title Page */
        return $this->title;
    }
    public function styleSheet($styleSheet)
    {
        /* use private $styleSheet (array) variable */
        $this->styleSheet = $styleSheet;
    }
    public function SetStyleSheet()
    {
        /* Return CSS Stylesheets which is in an array */
        return $this->styleSheet;
    }
    public function output()
    {
        $html = '';
        $html = '
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $this->SetPageTitle() . '</title>
    <link rel="shortcut icon" href="' . $this->SetIcon() . '">
';
        /* Get Stylesheets */
        $cssSheets = $this->SetStyleSheet();
        foreach ($cssSheets as $key) {
            $html .= '<link rel="stylesheet" href="' . $key . '">';
        }
        $html .= '</head>';
        echo $html;
    }

}

/*
class Testclass

{
private $testvar = "default value";

public function setTestvar($testvar) {
$this->testvar = $testvar;
}
public function getTestvar() {
return $this->testvar;
}

function dosomething()
{
echo $this->getTestvar();
}
}

$Testclass = new Testclass();

$Testclass->setTestvar("another value");

$Testclass->dosomething();

 */