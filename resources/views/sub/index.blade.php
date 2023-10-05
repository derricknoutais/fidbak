@extends('layouts.app')


@section('content')
    <div>
        <sub-create>

        </sub-create>

        <sub-index :subs="{{ json_encode($subs) }}" inline-template>

        </sub-index>
    </div>
@endsection
