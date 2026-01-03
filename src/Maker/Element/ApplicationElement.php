<?php

namespace Maker\Element;

class ApplicationElement extends AbstractElement
{
    private static ?ApplicationElement $instance = null;
    /**
     * Summary of namespaces
     * @var NamespaceElement[]
     */
    public array $namespaces;

    private function __construct(
        \stdClass $data
    ) {
        parent::__construct(data: $data);
        
        self::$instance = $this;//set singleton
/*
        //add Core namespace
        $core = new \stdClass();
        $core->name = "Core";
        $coreNameSpace = new NamespaceElement(application: $this, data: $core);

        //add Core valueObjects
        foreach (["Address", "AddressCommunication", "AddressLocation", "Amount", "City", "Country", "Category", "Currency", "DateTime", "Email", "Id", "Image", "Label", "Name", "Quantity", "State", "SimpleValueObject", "Title", "Unit", "Url", "ValidityPeriod", "ZipCode"] as $value) {
            new ValueObjectElement($coreNameSpace, $value);
        }*/

        //add namespaces
        if (property_exists(object_or_class: $data, property: 'namespaces')) {
            foreach ($data->namespaces as $namespace_data) {
                new NamespaceElement(application: $this, data: $namespace_data);
            }
        }
    }

    public static function get(string $ref=''): ApplicationElement
    {
        if (!self::$instance) {
            $file = 'src/application.json';
            $def = json_decode(file_get_contents($file));
            var_dump($def->key);
            self::$instance = new ApplicationElement($def);
        }

        return self::$instance;
    }

    public function addNamespace(NamespaceElement $namespace): self
    {
        $this->namespaces[$namespace->name] = $namespace;
        return $this;
    }

    public function getNamespace(string $key): NamespaceElement
    {
        return $this->namespaces[$key];
    }

}