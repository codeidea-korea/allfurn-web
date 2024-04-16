<section class="sub_section nopadding community_tab mb-10">
    <div class="inner">
        <ul>
            <li class="{{ Request::segment(2) != 'club' ? 'active' : '' }}"><a href="/community">커뮤니티 게시판</a></li>
            <li class="{{ Request::segment(2) == 'club' ? 'active' : '' }}"><a href="/community/club">가구인 모임</a></li>
        </ul>
    </div>
</section>