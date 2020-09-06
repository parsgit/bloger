<div class="uk-card">

  <div class="uk-card-body">
    <table class="uk-table uk-table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Published</th>
          <th>Last Update</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>

        @foreach($info->posts as $post)
        <tr>
          <td>{{$post->id}}</td>
          <td> <a target="_blank" href="{{$post->url}}">{{$post->title}}</a> </td>
          <td>{{$post->publish?'YES':'NO'}}</td>
          <td>{{$post->updated_at}}</td>
          <td>
            <button onclick="window.location.href='@url('admin/post/edit'."?id=$post->id")'" class="c-btn-icon color-green"> <i class="fas fa-edit"></i> </button>
            <button onclick="removePostMessage()" class="c-btn-icon color-red"> <i class="fas fa-trash"></i> </button>

          </td>
        </tr>
        @endforeach

      </tbody>
    </table>

    <div class="uk-margin-medium-top">
      <hr>

      <ul class="uk-pagination">

        @if($info->next)
        <li><a href="{{$info->next_page_url}}"><span uk-pagination-previous></span> Prev </a></li>
        @endif

        @if($info->prev)
        <li><a href="{{$info->prev_page_url}}">Next <span uk-pagination-next></span></a></li>
        @endif
      </ul>


    </div>

  </div>

</div>
