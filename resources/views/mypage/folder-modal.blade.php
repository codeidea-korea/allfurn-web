@foreach($folders as $folder)
<ul data-folder-id="{{ $folder->idx }}">
    <li class="textfield">
        <input type="text" value="{{ $folder->name }}" name="update_folder_name[]" data-folder-id="{{ $folder->idx }}" class="textfield__input textfield__input--gray">
        <span class="count">({{ $folder->product_count < 1000 ? $folder->product_count : "999+" }})</span>
    </li>
    <li><button type="button" onclick="removeFolder(this)" data-btn-type="modal" class="button button-delete">삭제</button></li>
</ul>
@endforeach
<ul name="add-folder" class="hidden">
    <li class="textfield">
        <input type="text" placeholder="폴더명을 입력해주세요." name="add_folder_name[]" maxlength="8" value="" class="textfield__input textfield__input--gray">
        <span class="count"></span>
    </li>
    <li><button type="button" onclick="removeFolder(this)" data-btn0-type="modal" class="button button-delete">삭제</button></li>
</ul>
