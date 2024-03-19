<div>
    <h3 class="text-xl font-bold">알림센터</h3>
    <ul class="my_menu_list mt-5">
        <li class="{{ !$type ? 'active' : '' }}">
            <a href="/alarm" class="flex p-4 justify-between">
                <p>전체</p>
                <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#my_arrow"></use></svg>
            </a>
        </li>
        <li class="{{ $type === 'order' ? 'active' : '' }}">
            <a href="/alarm/order" class="flex p-4 justify-between">
                <p>주문</p>
                <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#my_arrow"></use></svg>
            </a>
        </li>
        <li class="{{ $type === 'active' ? 'active' : '' }}">
            <a href="/alarm/active" class="flex p-4 justify-between">
                <p>활동</p>
                <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#my_arrow"></use></svg>
            </a>
        </li>
        <li class="{{ $type === 'news' ? 'active' : '' }}">
            <a href="/alarm/news" class="flex p-4 justify-between">
                <p>소식</p>
                <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#my_arrow"></use></svg>
            </a>
        </li>
    </ul>
</div>