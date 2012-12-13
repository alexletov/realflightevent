<div class="span10">
<table class="table table-hover">
<thead>
<tr>
<th>Flight</th>
<th>Aircraft</th>
<th>Gate</th>
<th>From</th>
<th>To</th>
<th>Departure</th>
<th>Arrival</th>
<th>BOOK!</th>
</tr>
</thead>
<tbody>
{foreach from=$flights item=flight}
<tr>
<td><img src="/styles/img/airlines/{strtoupper({$flight->airline})}.gif" alt="{$flight->airline}" width="85" height="18"/>{$flight->airline}{$flight->flight}</td>
<td>{$flight->aircraft}</td>
<td>{$flight->gate}</td>
<td><a href="#" class="tip" rel="tooltip" data-placement="bottom" title="{$flight->name1} ({$flight->city1}) - {$flight->country1}">{$flight->from}</a>&nbsp;<img src="/styles/img/flags/{strtolower($flight->iso1)}.png" alt="{$flight->iso1}" width="16" height="11"/></td>
<td><a href="#" class="tip" rel="tooltip" data-placement="bottom" title="{$flight->name2} ({$flight->city2}) - {$flight->country2}">{$flight->to}</a>&nbsp;<img src="/styles/img/flags/{strtolower($flight->iso2)}.png" alt="{$flight->iso2}" width="16" height="11"/></td>
<td>{$flight->dtime}</td>
<td>{$flight->atime}</td>
<td width="50em">{if $flight->booking_id gt 0}
<form action="#"><input type="button" class="btn btn-warning btn-small disabled" value="{$flight->vid}"/></form>
{else}
<form action="/book/add/{$flight->id}" method="post"><input class="btn btn-success btn-small" type="submit" value="Book"></form>
{/if}</td>
</tr>
{/foreach}
</tbody></table>
</div>
