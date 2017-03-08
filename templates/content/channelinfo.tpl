<h1><img src="{$channel.channellogo}" /> {$channel.channelname|escape} ({$channel.channelnumber})</h1>

<p>{$channel.description}</p>

{if $channel.channelurl}
    <p><strong>Website:</strong> <a href="{$channel.channelurl}">{$channel.channelurl}</a></p>
{/if}


<h3>Schedule for: {$date}</h3>

<table class="table table-striped">
    {foreach $schedule as $item}
        <tr>
            <td class="nowrap">
                {$item.starttime|date_format:"%I:%M %p"}
            </td>
            <td>


                {if $item.showtype}
                <strong><a href="/{$item.showtype}/{$item.shorturl}">{$item.title}</a></strong>
                {else}
                    <strong>{$item.title}</strong>
                {/if}

                <p>{$item.description|escape}</p>

            </td>
        </tr>
    {/foreach}
</table>

<a href="/channels/{$channel.channeltag}?date={$prevDay}" class="btn btn-default">Previous Day</a>
<a href="/channels/{$channel.channeltag}?date={$nextDay}" class="btn btn-default">Next Day</a>

