<% include Banner %>
<!-- BEGIN CONTENT -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="main col-sm-8">
              <% with $Region %>
                  <div class="blog-main-image">
                    $Photo
                  </div>
                  <h1 class="regions-page-h1">$Title</h1>
                  <p class="regions-page-p">$Description</p>
              <% end_with %>
            </div>
            <div class="sidebar gray col-sm-4">
              <h2 class="section-title">Regions</h2>
              <ul class="categories subnav">
                  <% loop $Regions %>
                      <li class="$LinkingMode"><a class="$LinkingMode" href="$Link">$Title</a></li>
                  <% end_loop %>
              </ul>
          </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->