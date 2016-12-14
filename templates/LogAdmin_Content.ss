<div class="cms-content flexbox-area-grow $BaseCSSClasses">
    <div id="left">
        <div class="Logs">
            <div class="Nav">
                <% if $LogList %>
                    <h2>Available Logs</h2>
                    <ul>
                        <% loop $LogList %>
                            <li><a href="admin/logs/show/$Slug">$Filename</a></li>
                        <% end_loop %>
                    </ul>
                <% end_if %>
            </div>
        </div>
    </div>
    <div id="right">
        <div class="Logs">
            <% if $Log %>
                <% loop $Log %>
                    <h2>$Filename ($Path)</h2>
                    <div class="Log">
$Data
                    </div>
                <% end_loop %>
            <% else %>
                <p>No logs available</p>
            <% end_if %>
        </div>
    </div>
</div>
