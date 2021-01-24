<?php

/**
 * Xml Parser Class that parses and tags Xml string data
 *
 * @package AWMain
 */
namespace AWMain;


class XmlParser
{
    private $xml_parser;
    private $parsed_data;
    private $element_name;
    private $arr_temporary_attributes;
    private $xml_string_to_parse;

    public function __construct(){
        $this->parsed_data = [];
    }

    public function __destruct(){
        xml_parser_free($this->xml_parser);
    }

    public function  resetXmlParser() {
        $this->xml_parser = null;
    }

    public function  setXmlStringToParse($xml_string_to_parse) {
        $this->xml_string_to_parse = $xml_string_to_parse;
    }

    public function getParsedData() {
        return $this->parsed_data;
    }

    public function parseTheXmlString() {
        $this->xml_parser = xml_parser_create();
        xml_set_object($this->xml_parser, $this);
        xml_set_element_handler($this->xml_parser, "open_element", "close_element");
        xml_set_character_data_handler($this->xml_parser, "process_element_data");
        $this->parseTheDataString();
    }

    public function parseTheDataString() {
        xml_parse($this->xml_parser, $this->xml_string_to_parse);
    }

    private function open_element($parser, $element_name, $attributes) {
        $this->element_name = $element_name;
        if (sizeof($attributes)>0) {
            foreach ($attributes as $att_name => $att_value) {
                $tag_att = $element_name . "." . $att_name;
                $this->arr_temporary_attributes[$tag_att] = $att_value;
            }
        }
    }

    private function process_element_data($parser, $element_data) {
        if (array_key_exists($this->element_name, $this->parsed_data) === false) {
            $this->parsed_data[$this->element_name] = $element_data;
            if (sizeof($this->arr_temporary_attributes)>0) {
                foreach ($this->arr_temporary_attributes as $tag_att_name => $tag_att_value) {
                    $this->parsed_data[$tag_att_name] = $tag_att_value;
                }
            }
        }
    }
    private function close_element($parser, $element_name) {}
}