@extends('frontend.frontend_dashboard')

@section('title')
{{$posts->post_title}} | RealEstate
@endsection


@section('main')

    <!--Page Title-->
    <section class="page-title-two bg-color-1 centred">
        <div class="pattern-layer">
            <div class="pattern-1" style="background-image: url({{asset('frontend/assets/images/shape/shape-9.png')}});"></div>
            <div class="pattern-2" style="background-image: url({{asset('assets/images/shape/shape-10.png')}});"></div>
        </div>
        <div class="auto-container">
            <div class="content-box clearfix">
                <h1>{{$posts->post_title}}</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="index.html">Home</a></li>
                    <li>{{$posts->post_title}}</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->


    <!-- sidebar-page-container -->
    <section class="sidebar-page-container blog-details sec-pad-2">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                    <div class="blog-details-content">
                        <div class="news-block-one">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image"><img src="{{asset($posts->post_image)}}" alt=""></figure>
                                    <span class="category">Featured</span>
                                </div>
                                <div class="lower-content">
                                    <h3>{{$posts->post_title}}</h3>
                                    <ul class="post-info clearfix">
                                        <li class="author-box">
                                            <figure class="author-thumb"><img src="{{ (!empty($item->user->photo)) ? url('upload/admin_images/'.$item->user->photo) 
                                                : url('upload/no_image.jpg') }}" alt=""></figure>
                                            <h5><a href="blog-details.html">{{$posts->user->name}}</a></h5>
                                        </li>
                                        <li>{{$posts->created_at->format('M d Y')}}</li>
                                    </ul>
                                    <div class="text">
                                        <p>{!! $posts->long_descp !!}</p>
                                    </div>
                                    <div class="post-tags">
                                        <ul class="tags-list clearfix">
                                            <li><h5>Tags:</h5></li>
                                            @foreach ($tags as $tag)
                                            <li><a href="blog-details.html">{{ucwords($tag)}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $comments = App\Models\Comment::where('post_id',$posts->id)->where('parent_id',null)->limit(5)->get();
                        @endphp
                        <div class="comments-area">
                            <div class="group-title">
                                <h4>{{count($comments)}} Comments</h4>
                            </div>
                            @foreach ($comments as $comment)
                            <div class="comment-box">
                                <div class="comment">
                                    <figure class="thumb-box">
                                        <img src="{{(!empty($comment->user->photo)) ? url('upload/user_images/'.$comment->user->photo) 
                                        : url('upload/no_image.jpg')}}" alt="">
                                    </figure>
                                    <div class="comment-inner">
                                        <div class="comment-info clearfix">
                                            <h5>{{$comment->user->name}}</h5>
                                            <span>{{$comment->created_at->format('M d Y')}}</span>
                                        </div>
                                        <div class="text">
                                            <p>{{$comment->subject}}</p>
                                            <p>{{$comment->message}}</p>
                                            <a href="blog-details.html"><i class="fas fa-share"></i>Reply</a>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $replies = App\Models\Comment::where('parent_id',$comment->id)->get();
                                @endphp
                                @foreach ($replies as $reply)
                                <div class="comment replay-comment">
                                    <figure class="thumb-box">
                                        <img src="{{url('upload/admin.png')}}" alt="">
                                    </figure>
                                    <div class="comment-inner">
                                        <div class="comment-info clearfix">
                                            <h5>{{$reply->subject}}</h5>
                                            <span>{{$reply->created_at->format('M d Y')}}</span>
                                        </div>
                                        <div class="text">
                                            <p>{{$reply->message}}</p>
                                            <a href="blog-details.html"><i class="fas fa-share"></i>Reply</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                        <div class="comments-form-area">
                            <div class="group-title">
                                <h4>Leave a Comment</h4>
                            </div>
                            @auth                         
                            <form action="{{route('store.comment')}}" method="post" class="comment-form default-form">
                                @csrf
                                <input type="hidden" name="post_id" value="{{$posts->id}}">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <input type="text" name="subject" placeholder="Subject" required="">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <textarea name="message" placeholder="Your message"></textarea>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button type="submit" class="theme-btn btn-one">Submit Now</button>
                                    </div>
                                </div>
                            </form>
                            @else
                            <P><b>For Adding a comment You have to login first <a href="{{route('login')}}">Login here</a></b></P>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                    <div class="blog-sidebar">
                        <div class="sidebar-widget search-widget">
                            <div class="widget-title">
                                <h4>Search</h4>
                            </div>
                            <div class="search-inner">
                                <form action="blog-1.html" method="post">
                                    <div class="form-group">
                                        <input type="search" name="search_field" placeholder="Search" required="">
                                        <button type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-widget social-widget">
                            <div class="widget-title">
                                <h4>Follow Us On</h4>
                            </div>
                            <ul class="social-links clearfix">
                                <li><a href="blog-1.html"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="blog-1.html"><i class="fab fa-google-plus-g"></i></a></li>
                                <li><a href="blog-1.html"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="blog-1.html"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="blog-1.html"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                        <div class="sidebar-widget category-widget">
                            <div class="widget-title">
                                <h4>Category</h4>
                            </div>
                            <div class="widget-content">
                                <ul class="category-list clearfix">
                                    @foreach ($blogCategory as $item) 
                                    @php
                                        $blogpost = App\Models\BlogPost::where('blogcat_id',$item->id)->get();
                                    @endphp 
                                    <li><a href="{{route('blog.category.list',$item->id)}}">{{$item->category_name}}<span>({{count($blogpost)}})</span></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget post-widget">
                            <div class="widget-title">
                                <h4>Recent Posts</h4>
                            </div>
                            <div class="post-inner">
                                @foreach ($recent_posts as $item)
                                <div class="post">
                                    <figure class="post-thumb"><a href="{{route('blog.details',$item->post_slug)}}"><img src="{{asset($item->post_image)}}" alt=""></a></figure>
                                    <h5><a href="{{route('blog.details',$item->post_slug)}}">{{$item->post_title}}</a></h5>
                                    <span class="post-date">{{$item->created_at->format('M d Y')}}</span>
                                </div> 
                                @endforeach 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- sidebar-page-container -->

    <!-- subscribe-section -->
    <section class="subscribe-section bg-color-3">
        <div class="pattern-layer" style="background-image: url(assets/images/shape/shape-2.png);"></div>
        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-12 text-column">
                    <div class="text">
                        <span>Subscribe</span>
                        <h2>Sign Up To Our Newsletter To Get The Latest News And Offers.</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 form-column">
                    <div class="form-inner">
                        <form action="contact.html" method="post" class="subscribe-form">
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Enter your email" required="">
                                <button type="submit">Subscribe Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- subscribe-section end -->

@endsection