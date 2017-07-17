<%
use Cake\Utility\Inflector;

unset($behaviors['Timestamp']);

$annotations = [];
foreach ($associations as $type => $assocs) {
    foreach ($assocs as $assoc) {
        $typeStr = Inflector::camelize($type);
        $tableFqn = $associationInfo[$assoc['alias']]['targetFqn'];
        $parts = explode('\\', $tableFqn);
        $tableClass = end($parts);
        $annotations[] = "@property {$tableClass}|Association\\{$typeStr} \${$assoc['alias']}";
    }
}
$annotations[] = "@method {$entity} get(\$primaryKey, \$options = [])";
$annotations[] = "@method {$entity} newEntity(\$data = null, array \$options = [])";
$annotations[] = "@method {$entity}[] newEntities(array \$data, array \$options = [])";
$annotations[] = "@method {$entity}|bool save(Entity \$entity, \$options = [])";
$annotations[] = "@method {$entity} patchEntity(Entity \$entity, array \$data, array \$options = [])";
$annotations[] = "@method {$entity}[] patchEntities(\$entities, array \$data, array \$options = [])";
$annotations[] = "@method {$entity} findOrCreate(\$search, callable \$callback = null, \$options = [])";
foreach ($behaviors as $behavior => $behaviorData) {
    $annotations[] = "@mixin Behavior\\{$behavior}Behavior";
}
%>
<?php
declare(strict_types = 1);

<%= 'namespace ' . $namespace %>\Model\Table;

<%
$uses = [
    'use Cake\Datasource\EntityInterface as Entity;',
    'use Cake\ORM\Association;',
    'use Cake\ORM\RulesChecker;',
    'use Cake\Validation\Validator;',
    "use {$namespace}\\Model\\Entity\\{$entity};",
];
if (count($behaviors)) {
    $uses[] = 'use Cake\ORM\Behavior;';
}
sort($uses);
echo implode("\n", $uses);
%>


<%= $this->DocBlock->classDescription($name, 'Model', $annotations) %>
class <%= $name %>Table extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
<% if (!empty($primaryKey) && count($primaryKey) > 1): %>

        $this->setPrimaryKey([<%= $this->Bake->stringifyList((array)$primaryKey, ['indent' => false]) %>]);
<% endif %>
<% if (!empty($behaviors)): %>

<% endif; %>
<% foreach ($behaviors as $behavior => $behaviorData): %>
        $this->addBehavior('<%= $behavior %>'<%= $behaviorData ? ", [" . implode(', ', $behaviorData) . ']' : '' %>);
<% endforeach %>
<% if (!empty($associations['belongsTo']) || !empty($associations['hasMany']) || !empty($associations['belongsToMany'])): %>

<% endif; %>
<% foreach ($associations as $type => $assocs): %>
<% foreach ($assocs as $assoc):
	$alias = $assoc['alias'];
	unset($assoc['alias']);
%>
        $this-><%= $type %>('<%= $alias %>');
<% endforeach %>
<% endforeach %>
    }
<% if (!empty($validation)): %>

    /**
     * {@inheritdoc}
     */
    public function validationDefault(Validator $validator): Validator
    {
        return parent::validationDefault($validator)
<%
$validationMethods = [];
foreach ($validation as $field => $rules):
    if (in_array($field, ['id', 'slug'], true)) {
        continue;
    }
    $fieldValidationMethods = [];
    foreach ($rules as $ruleName => $rule):
        if ($rule['rule'] && !isset($rule['provider'])):
            $fieldValidationMethods[] = sprintf("->%s('%s')", $rule['rule'], $field);
        elseif ($rule['rule'] && isset($rule['provider'])):
            $fieldValidationMethods[] = sprintf(
                "->add('%s', '%s', ['rule' => '%s', 'provider' => '%s'])",
                $field,
                $ruleName,
                $rule['rule'],
                $rule['provider']
            );
        endif;

        if (isset($rule['allowEmpty'])):
            if (is_string($rule['allowEmpty'])):
                $fieldValidationMethods[] = sprintf(
                    "->allowEmpty('%s', '%s')",
                    $field,
                    $rule['allowEmpty']
                );
            elseif ($rule['allowEmpty']):
                $fieldValidationMethods[] = sprintf(
                    "->allowEmpty('%s')",
                    $field
                );
            else:
                $fieldValidationMethods[] = sprintf(
                    "->requirePresence('%s', 'create')",
                    $field
                );
                $fieldValidationMethods[] = sprintf(
                    "->notEmpty('%s')",
                    $field
                );
            endif;
        endif;
    endforeach;
    sort($fieldValidationMethods);
    $validationMethods = array_merge($validationMethods, ["// ${field}"], $fieldValidationMethods);
endforeach;
$validationMethods[count($validationMethods) - 1] .= ';';
    if (!empty($validationMethods)):
        %>
        <%- foreach ($validationMethods as $validationMethod): %>
            <%= $validationMethod %>
        <%- endforeach; %>
<%
    endif;
%>
    }
<% endif %>
<% if (!empty($rulesChecker)): %>

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
    <%- $i = 0; $ruleCount = count($rulesChecker); foreach ($rulesChecker as $field => $rule): $i++; %>
            ->add($rules-><%= $rule['name'] %>(['<%= $field %>']<%= !empty($rule['extra']) ? ", '$rule[extra]'" : '' %>))<%= ($i === $ruleCount) ? ';' : '' %>
    <%- endforeach; %>
    }
<% endif; %>
<% if ($connection !== 'default'): %>

    public static function defaultConnectionName(): string
    {
        return '<%= $connection %>';
    }
<% endif; %>
}
