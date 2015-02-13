<?php

class TestCase extends PHPUnit_Framework_TestCase
{
  protected function getData() {
    return json_decode(file_get_contents(__DIR__ . '/_data/base.json'));
  }

  protected function createField($data, $class) {
    return new $class(
      $data->name,
      $data->title,
      $data->description,
      $data->duplicated,
      $data->required,
      $data->type,
      (array)$data->options
    );
  }

  protected function getFieldMock() {
    return $this->getMockByClassName('Structs\Field');
  }

  protected function getFieldFactoryMock() {
    return $this->getMockByClassName('Factories\FieldFactory');
  }

  protected function getGroupMock() {
    return $this->getMockByClassName('Structs\Group');
  }

  protected function getMockByClassName($class) {
    $class = $this->prependClass($class);
    return $this->getMockBuilder($class)
                ->disableOriginalConstructor()
                ->getMock();
  }

  private function prependClass($class) {
    return 'GoBrave\PostTypeImporter\\' . $class;
  }

  protected function getNamespace() {
    return 'GoBrave\\PostTypeImporter\\Structs\\';
  }

  protected function typeToClass($type) {
    $base  = $this->getNamespace();
    $class = 'Field';
    if($type == 'textbox') {
      $class = 'FieldTextBox';
    } else if($type == 'image_media') {
      $class = 'FieldImageMedia';
    } else if($type == 'markdown_editor') {
      $class = 'FieldMarkdownEditor';
    } else if($type == 'checkbox_list') {
      $class = 'FieldCheckboxList';
    } else if($type == 'checkbox') {
      $class = 'FieldCheckbox';
    } else if($type == 'multiline') {
      $class = 'FieldMultiline';
    } else if($type == 'related_type') {
      $class = 'FieldRelatedType';
    } else if($type == 'file') {
      $class = 'FieldFile';
    } else if($type == 'dropdown') {
      $class = 'FieldDropdown';
    } else if($type == 'radiobutton_list') {
      $class = 'FieldRadiobuttonList';
    }

    return implode('', [$base, $class]);
  }

  protected function imageSizeMock() {
    $mock  = $this->getMockBuilder('GoBrave\PostTypeImporter\Structs\ImageSize')
                  ->setConstructorArgs(['featured-image', 100, 100, true])
                  ->getMock();
    $mock->method('getName')
         ->willReturn('featured-image');
    return $mock;
  }
}
