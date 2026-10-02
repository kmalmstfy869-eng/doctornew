@props(['url'])
<tr>
<td align="center">
<table class="header-table" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="header" align="center">
<a href="{{ $url }}" style="display: inline-block;">
{!! $slot !!}
</a>
</td>
</tr>
</table>
</td>
</tr>
