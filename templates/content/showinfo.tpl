{$show|var_dump}

<div class="row">
{if $show.showimage}
    <div class="col-md-3">
        <img src="{$show.showimage}?" class="img-responsive" >
    </div>
    <div class="col-md-9">
    {else}
    <div class="col-md-12">
{/if}

<h1>{$show.title}</h1>

<p>{$show.description}</p>

{if $show.director}
    <p><strong>Director(s):</strong> {$show.director}</p>
{/if}

{if $show.actors}
    <p><strong>Actor(s):</strong> {Utils::explodePipe($show.actors)}</p>
{/if}

<p><strong>IMDB Rating:</strong> {$show.imdb_rating}</p>

{if $show.website}
    <p><strong>Website:</strong> <a href="{$show.website}">{$show.website}</a></p>
{/if}

</div>

<br clear="both" />
<h1>Schedule</h1>
<h1>See Also</h1>