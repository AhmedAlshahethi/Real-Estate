<nav class="sidebar">
    <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
        Easy<span>Admin</span>
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">
      <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item nav-category">RealEstate</li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">Property Type </span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="emails">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('all.type') }}" class="nav-link">All Type</a>
              </li>
              <li class="nav-item">
                <a href="pages/email/read.html" class="nav-link">Add Type</a>
              </li>
              
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#state" role="button" aria-expanded="false" aria-controls="emails">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">State </span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="state">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('all.state') }}" class="nav-link">All Stats</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('add.state') }}" class="nav-link">Add State</a>
              </li>
              
            </ul>
          </div>
        </li>

         <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#amenitie" role="button" aria-expanded="false" aria-controls="emails">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">Amenitie  </span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="amenitie">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('all.amenitie') }}" class="nav-link">All Amenitie</a>
              </li>
              <li class="nav-item">
                <a href="pages/email/read.html" class="nav-link">Add Amenitie</a>
              </li>
              
            </ul>
          </div>
        </li>


         <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#property" role="button" aria-expanded="false" aria-controls="emails">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">Property  </span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="property">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('all.property') }}" class="nav-link">All Property</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('add.property') }}" class="nav-link">Add Property</a>
              </li>
              
            </ul>
          </div>
        </li>
        
        <li class="nav-item">
          <a href="{{route('admin.package.history')}}" class="nav-link">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">Package History</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('admin.property.message')}}" class="nav-link">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">Property Messages</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#testimonial" role="button" aria-expanded="false" aria-controls="emails">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">Manage Testimonials  </span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="testimonial">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ route('all.testimonials') }}" class="nav-link">All Testimonials</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('add.testimonial') }}" class="nav-link">Add Testimonial</a>
              </li>
              
            </ul>
          </div>
        </li>

        <li class="nav-item nav-category">Users</li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
            <i class="link-icon" data-feather="feather"></i>
            <span class="link-title">Manage Users</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="uiComponents">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{route('all.agent')}}" class="nav-link">All Agents</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Add Agent</a>
              </li>
              
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#blogCategories" role="button" aria-expanded="false" aria-controls="uiComponents">
            <i class="link-icon" data-feather="feather"></i>
            <span class="link-title">Blog Categories</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="blogCategories">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{route('all.blog.Categories')}}" class="nav-link">All Blog Categories</a>
              </li>             
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#blogPosts" role="button" aria-expanded="false" aria-controls="uiComponents">
            <i class="link-icon" data-feather="feather"></i>
            <span class="link-title">Blog Posts</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="blogPosts">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{route('all.blog.posts')}}" class="nav-link">All Blog Posts</a>
              </li> 
              <li class="nav-item">
                <a href="{{route('add.blog.post')}}" class="nav-link">Add Blog Post</a>
              </li>            
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a href="{{route('all.blog.comment')}}" class="nav-link">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">All Blog Comments</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('smtp.setting')}}" class="nav-link">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">SMTP Setting</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('site.setting')}}" class="nav-link">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">Site Setting</span>
          </a>
        </li>


        
        <li class="nav-item nav-category">Roles & Permissions</li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#permissions" role="button" aria-expanded="false" aria-controls="uiComponents">
            <i class="link-icon" data-feather="feather"></i>
            <span class="link-title">Roles & Permissions</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="permissions">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{route('all.permissions')}}" class="nav-link">All Permissions</a>
              </li>
              <li class="nav-item">
                <a href="{{route('add.permission')}}" class="nav-link">Add Permisiion</a>
              </li>
              <li class="nav-item">
                <a href="{{route('all.roles')}}" class="nav-link">All Roles</a>
              </li>
              <li class="nav-item">
                <a href="{{route('add.role')}}" class="nav-link">Add Role</a>
              </li>
              <li class="nav-item">
                <a href="{{route('add.role.permission')}}" class="nav-link">Add Role in Permission</a>
              </li>
              <li class="nav-item">
                <a href="{{route('all.role.permission')}}" class="nav-link">All Roles in Permission</a>
              </li>
              
            </ul>
          </div>
        </li>

        {{-- <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#roles" role="button" aria-expanded="false" aria-controls="uiComponents">
            <i class="link-icon" data-feather="feather"></i>
            <span class="link-title">Roles & Permissions</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="roles">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{route('all.roles')}}" class="nav-link">All Roles</a>
              </li>
              <li class="nav-item">
                <a href="{{route('add.role')}}" class="nav-link">Add Role</a>
              </li>
              
            </ul>
          </div>
        </li> --}}


        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
            <i class="link-icon" data-feather="anchor"></i>
            <span class="link-title">Advanced UI</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="advancedUI">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="pages/advanced-ui/cropper.html" class="nav-link">Cropper</a>
              </li>
              <li class="nav-item">
                <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Owl carousel</a>
              </li>
              
            </ul>
          </div>
        </li>
        
         
        
      
        
        <li class="nav-item nav-category">Docs</li>
        <li class="nav-item">
          <a href="#" target="_blank" class="nav-link">
            <i class="link-icon" data-feather="hash"></i>
            <span class="link-title">Documentation</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>