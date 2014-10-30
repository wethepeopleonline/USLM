<?php

namespace USLM\Legislation\Element\LegisBody;

use \Exception;

class QuotedBlock extends LegisBodyElement {

  public function asMarkdown() {
    $this->checkRequirements(array('xml'));

    $after = (string)$this->xml->{'after-quoted-block'};

    $block = $this->xml;
    unset($block->{'after-quoted-block'});

    $markdown = "";
    $markdown .= "***\n";
    $children = $this->xml->children();

    foreach($children as $child){
      switch($child->getName()){
        case 'paragraph':
          $element = new Paragraph();
          break;
        case 'section':
          $element = new Section();
          break;
        case 'subsection':
          $element = new Subsection();
        default:
          throw new Exception(get_class($this) . ' -> ' . $child->getName() . ' has not yet been implemented.');
      }

      $element->simplexml($child);
      $childMarkdown = $element->asMarkdown();
      $childMarkdown = preg_replace('/^[\s\*]*/m', '', $childMarkdown);
      $childMarkdown = preg_replace('/^__([^\s]+)__/m', '$1', $childMarkdown);
      $childMarkdown = preg_replace('/^__(.*?)__$/m', '$1', $childMarkdown);
      $markdown .= $childMarkdown;
    }
    //$markdown .= preg_replace('/^\s+/m', '', trim(strip_tags($block->asXML())));
    $markdown .= "\n***";
    
    if((bool)$after){
      $markdown .= "\n" . (string)$after;
    }

    return $markdown;
  }
}