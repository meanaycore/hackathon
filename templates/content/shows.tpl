<h1>{$title}</h1>

<div class="row ">
    {foreach $shows as $show}

    <div class="col-md-3">
        <div class="well text-center">
            <a href="/{$showType}/{$show.shorturl}">
            {$show.title} - {$show.imdb_rating}
            <img src="{$show.showimage}?a" class="img-responsive" /></a>

        </div>
    </div>



    {/foreach}
</div>
