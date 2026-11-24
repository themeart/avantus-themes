{extends file="{$parent_template_path}layout/header.tpl"}

{* Shared assets belong to the parent; template lookup still uses the child first. *}
{block name='layout-header'}
    {$currentTemplateDir = $parentTemplateDir}
    {$currentTemplateDirFullPath = $parent_template_path}
    {$smarty.block.parent}
{/block}

