<div class="Logs">
	<div class="Nav">
		<% if logNav %>
		<h2>Available Logs</h2>
		<ul>
		<% control logNav %>
			<li><a href="admin/logs/show/$Pos">$File</a></li>
		<% end_control %>
		</ul><% end_if %>
	</div>
</div>