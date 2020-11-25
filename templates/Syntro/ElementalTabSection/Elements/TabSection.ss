<div class="row justify-content-center text-center">
    <% if ShowTitle || Content %>
        <div class="{$ElementName}__contentholder col-12 col-md-10 col-lg-8 mb-4">
            <% if ShowTitle %>
                <h2 class="mb-4 {$ElementName}__title">$Title</h2>
            <% end_if %>
            <% if $Content %>
            <p class="{$ElementName}__content">$Content</p>
            <% end_if %>
        </div>
    <% end_if %>
    <div class="w-100"></div>

    <div class="col-12 {$ElementName}__tabmenu mb-3">
        <ul class="nav nav-pills justify-content-center">
            <% loop TabPanels %>
                <li class="nav-item">
                    <button id="Tab-{$Up.ID}-{$ID}" class="nav-link btn btn-link <% if $First %> active<% end_if %>" data-toggle="tab" href="#TabPanel-{$Up.ID}-{$ID}" role="tab" aria-controls="Tab-{$Up.ID}-{$ID}" aria-selected="<% if $First %>true<% else %>false<% end_if %>">
                        $Title
                    </button>
                </li>
            <% end_loop %>
        </ul>
    </div>
    <div class="col-12 {$ElementName}__tabpanels tab-content text-left">
        <% loop $TabPanels %>
            <div class="tab-pane fade<% if $First %> show active<% end_if %>" id="TabPanel-{$Up.ID}-{$ID}" role="tabpanel" aria-labelledby="home-tab">
                $Content
            </div>
        <% end_loop %>
    </div>
</div>
