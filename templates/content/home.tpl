<h1>Dummy Content from DB</h1>

<p>Note: this is <a href="http://www.smarty.net/">smarty syntax</a></p>

<ul>
{foreach $packages as $package}
    <li>
        <strong>{$package.title|escape}</strong>
        
        <br />{$package.packagecode}
        
        <br />&nbsp;
    </li>
{/foreach}
</ul>