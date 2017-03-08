<div class="jumbotron">
    <h1>Hello, world!</h1>
    <p>...</p>
    <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
</div>

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