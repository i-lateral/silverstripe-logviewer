<div class="Logs">
    <div class="Nav">
        <% if LogList %>
            <h2>Available Logs</h2>
            <ul>
            <% control LogList %>
                <li><a href="admin/logs/show/$Slug">$File</a></li>
            <% end_control %>
            </ul>
        <% end_if %>
    </div>
</div>