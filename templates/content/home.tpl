

<h1>Top Movies Showing Today</h1>

{foreach $movies as $item}
    <div class="media">
        <div class="media-left media-top">
            <a href="#">
                <img class="media-object" src="{$item.showimage}?a" class="img-responsive" style=" max-width: 100px"/>
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">
                <a href="/movie/{$item.shorturl}">{$item.title}</a>
            </h4>
            <p>{$item.description|truncate:400}</p>
        </div>
    </div>
{/foreach}


<h1>Top Series Showing Today</h1>

{foreach $series as $item}
    <div class="media">
        <div class="media-left media-top">
            <a href="#">
                <img class="media-object" src="{$item.showimage}?a" class="img-responsive" style=" max-width: 100px"/>
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">
                <a href="/series/{$item.shorturl}">{$item.title}</a>
            </h4>
            <p>{$item.description|truncate:400}</p>
        </div>
    </div>
{/foreach}