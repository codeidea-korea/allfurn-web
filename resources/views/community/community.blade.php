@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <section class="sub_section nopadding community_tab mb-10">
        <div class="inner">
            <ul>
                <li class="active"><a href="javascript:;">커뮤니티 게시판</a></li>
                <li><a href="/community/group">가구인 모임</a></li>
            </ul>
        </div>
    </section>


    <section class="sub_section nopadding">
        <div class="inner">
            <div class="line_common_banner">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide" style="background-color:#475872; ">
                        <a href="javascript:;">
                            <div class="txt_box">
                                <p>[가구,가구인] <br/>가구인의 인터뷰 시리즈를 확인해보세요!</p>
                                <span>매달 5일과 15일에 게시됩니다.</span>
                            </div>
                        </a>
                    </li>
                    <li class="swiper-slide" style="background-color:#6D5C64; ">
                        <a href="javascript:;">
                            <div class="txt_box">
                                <p>[가구,가구인] <br/>가구인의 인터뷰 시리즈를 확인해보세요!</p>
                                <span>매달 5일과 15일에 게시됩니다.</span>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="count_pager"><b>1</b> / 12</div>
                <button class="slide_arrow prev type03"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                <button class="slide_arrow next type03"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            </div>
        </div>
    </section>
    
    <section class="sub_section community_con01">
        <div class="inner">
            <div class="title">
                <div class="search_box">
                    <input type="text" class="input-form" placeholder="글 제목이나 작성자를 검색해주세요">
                    <button><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#news_search"></use></svg></button>
                </div>
            </div>

            <div class="tab_layout type02">
                <ul>
                    <li class="active"><a href="javascript:;">전체</a></li>
                    <li><a href="javascript:;">상품문의</a></li>
                    <li><a href="javascript:;">홍보</a></li>
                    <li><a href="javascript:;">일상</a></li>
                    <li><a href="javascript:;">매매/임대</a></li>
                    <li><a href="javascript:;">구인구직</a></li>
                </ul>
            </div>

            <div class="tab_content">
                <!-- 전체 -->
                <div class="active">
                    <div class="community_list">
                        <ul>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>매매/임대</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb3.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>매매/임대</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb4.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>매매/임대</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb5.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>매매/임대</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb2.png" alt=""></a></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 상품문의 -->
                <div>
                    <div class="community_list">
                        <ul>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>상품문의</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>상품문의</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb2.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>상품문의</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb5.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>상품문의</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb3.png" alt=""></a></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 홍보 -->
                <div>
                    <div class="community_list">
                        <ul>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>홍보</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb5.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>홍보</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb3.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>홍보</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>홍보</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb4.png" alt=""></a></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 일상 -->
                <div>
                    <div class="community_list">
                        <ul>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>일상</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>일상</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>일상</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>일상</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb3.png" alt=""></a></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 매매/임대 -->
                <div>
                    <div class="community_list">
                        <ul>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>매매/임대</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb2.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>매매/임대</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/sale_thumb.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>매매/임대</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>매매/임대</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb5.png" alt=""></a></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 구인구직 -->
                <div>
                    <div class="community_list">
                        <ul>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>구인구직</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>구인구직</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb2.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>구인구직</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb3.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="./community_detail.php">
                                            <div class="category">
                                                <span>구인구직</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="./community_detail.php"><img src="./img/prod_thumb4.png" alt=""></a></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="./community_write.php" class="btn btn-round btn-primary px-4"><svg class="w-5 h-5 mr-1"><use xlink:href="./img/icon-defs.svg#write_add"></use></svg>글쓰기</a>
            </div>
        </div>
    </section>

</div>


<script>
    // line_common_banner 
    const line_common_banner = new Swiper(".line_common_banner", {
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
            nextEl: ".line_common_banner .slide_arrow.next",
            prevEl: ".line_common_banner .slide_arrow.prev",
        },
        pagination: {
            el: ".line_common_banner .count_pager",
            type: "fraction",
        }
    });

    // 탭 컨트롤
    $('.tab_layout li').on('click',function(){
        let liN = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $('.tab_content > div').eq(liN).addClass('active').siblings().removeClass('active');
    })
</script>

@endsection