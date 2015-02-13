PLAN

PostType
  $name
  $singular
  $plural
  $prefix
  $rewrite
  $has_page
  $single
  $rewrite
  $groups

  - toArray()
    $array = []
    foreach $groups as $group
      $array[] = $group->toMagicFields()
    return $array

Group
  $name
  $title
  $duplicated
  $fields

  - toArray()
    $array = []
    foreach $fields as $field
      $array[] = $field->toMagicFields()
    return $array

Field

  $default_options = array( ... )
  $base_name

  $name
  $title
  $description
  $duplicated
  $required
  $type
  $options

  - toArray()
    $array = [
      name => $name
      ...
      ...
      options = $options
    ]
  - mergeOptions($options) : array()






FieldFactory
  $base_namespace
  $image_sizes

  - create($data) : Structs\Field


GroupFactory

  $field_factory

  - create($data) : Structs\Group


PostTypeFactory

  $group_factory

  - create($data) : Structs\PostType
