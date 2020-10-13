<div class="container">
  <div class="p-3">

    <h2>{{$index->name->data}}</h2>


    <div class="p-3 mt-3">
      <div class="">
        {!! $index->text_1->data !!}
      </div>



      <div class="mt-5">
        <h3>New Posts</h3>
      </div>

      <div class="row justify-content-center mt-3">

        @foreach($posts->posts as $post)
        <div class="col-4 mt-2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-center"> <a href="{{$post->url}}">{{$post->title}}</a> </h5>

            </div>

          </div>
        </div>

        @endforeach

      </div>

      <div class="mt-5">
        <h3>Items</h3>
      </div>
      <div class="row justify-content-center mt-3">

        @foreach($index->items->params as $item)
        <div class="col-4 mt-2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">{{$item[0]->data}}</h5>
              {!! $item[1]->data !!}
            </div>

          </div>
        </div>

        @endforeach

      </div>

    </div>

  </div>
</div>
