@extends('layouts.master')
@section('title','書籍觀看')
@section('content')
        <!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="container-fluid" style="padding:0;">
            <div style="position: relative;">
                <button style="float: right" class="btn btn-info" data-toggle="modal" data-target="#createproduct">
                    +新增折價券
                </button>
            </div>
        </div>
    </div>
</div>
<div class="container">
    @if(session('response'))
        <div class="alert alert-success">{{session('response')}}</div>
    @endif
</div>
<div class="modal fade" id="createproduct" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button class="close" data-dismiss="modal">×</button>
                <h2 class="modal-title & text-center & text-info"><strong>新增折價券</strong></h2>

            </div>
            <form action="{{route('coustore')}}" method="POST" role="form" enctype="multipart/form-data"
                  onsubmit="return ConfirmCreate()">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>標題</label>
                        <textarea name="title" class="form-control" rows="1" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>起始時間</label>
                        <input type="datetime-local" name="start" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>結束時間</label>
                        <input type="datetime-local" name="end" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>折扣金額</label>
                        <textarea name="discount" class="form-control" rows="1"></textarea>
                    </div>
                    <div class="form-group">
                        <label>至少購物金額</label>
                        <textarea name="lowestprice" class="form-control" rows="1"></textarea>
                    </div>
                    <div class="form-group">
                        <label>上傳圖片</label>
                        <input type="file" class="form-control" name="picture" id="picture">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary ">新增</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">

    <h2 class="text-center & text-success"><strong>折價券管理</strong></h2>
    <hr class="colorgraph">
    <table class="table">
        <thead>
        <tr>


            <th>折價券名稱</th>
            <th>起始時間</th>
            <th>結束時間</th>
            <th>折扣金額</th>
            <th>至少購物金額</th>
            <th>發送狀態</th>
            <th>功能</th>
            <th>發送折價券</th>
            <th>已兌換數量</th>
        </tr>
        </thead>
        <tbody>
        @foreach($coupons as $coupon )
            <tr>

                <td>{{$coupon->title}}</td>
                <td>{{$coupon->start}}</td>
                <td>{{$coupon->end}}</td>
                <td>{{$coupon->discount}}元</td>
                <td>{{$coupon->lowestprice}}元</td>
                <td>@if($coupon->status ==0)
                        <a class="text-danger"><strong>未發送</strong></a>
                    @elseif(($coupon->status==1))
                        <a class="text-danger"><strong>已發送</strong></a>
                    @endif</td>
                <td>
                    <button class="btn btn-success "><a href="{{route('couview',$coupon->id)}}"
                                                        style="color: white"><strong>詳細</strong></a></button>
                    @if($coupon->status==1)
                        <button class="btn btn-warning " disabled=""><a href="{{route('couedit',$coupon->id)}}"
                                                                        style="color: white"><strong>編輯</strong></a>
                        </button>
                    @else
                        <button class="btn btn-warning "><a href="{{route('couedit',$coupon->id)}}"
                                                            style="color: white"><strong>編輯</strong></a></button>
                    @endif
                    {{--<form action="{{ route('pushdestroy', $push->id) }}" method="POST">--}}
                    {{--{{ csrf_field() }}--}}
                    {{--{{ method_field('DELETE') }}--}}
                    @if($coupon->status==1)
                        <button class=" btn btn-danger " disabled><a href="{{route('coudestroy',$coupon->id)}}"
                                                                     style="color: white"><strong>刪除</strong></a>
                        </button>
                            @else
                                <button class=" btn btn-danger "><a href="{{route('coudestroy',$coupon->id)}}"
                                                                    style="color: white"><strong>刪除</strong></a>
                                    @endif
                                </button>
                </td>
                <td>
                    <button class="btn btn-primary "><a href="{{route('couponchange',$coupon->id)}}"
                                                        style="color:white"><strong>發送</strong></a></button>
                </td>
                <td>{{$coupon->count}}張</td>
            </tr>

        @endforeach
        </tbody>
    </table>
</div>


</body>
</html>
@endsection