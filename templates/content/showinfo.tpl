<div class="row">
{if $show.showimage}
    <div class="col-md-3" style="padding-top: 20px;">
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

        <table class="table table-striped">

            <thead>
                <th>Date</th>
                <th>Time</th>
                <th>Show</th>
                <th>Channel</th>
            </thead>

            {foreach $schedule as $item}
                <tr>
                    <td class="nowrap">
                        {$item.program_date}
                    </td>
                    <td class="nowrap">
                        {$item.starttime|date_format:"%I:%M %p"}
                    </td>
                    <td>

                        <strong>{$item.title}</strong>

                        {if $item.season_id}
                            - Season {$item.season_id}
                        {/if}

                        {if $item.episode_id}
                            - Episode {$item.episode_id}
                        {/if}

                        <p>{$item.description|escape}</p>

                    </td>
                    <td class="text-center">
                        <a href="/channels/{$item.channel_tag}?date={$item.program_date}">
                        <img src="{$item.channellogo}">
                        </a>

                        {$item.channelnumber}
                    </td>
                </tr>
            {/foreach}
        </table>

<h1>See Also</h1>