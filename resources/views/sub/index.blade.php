@extends('layouts.app')


@section('content')
<sub-create >

</sub-create>
<sub-index :subs="{{ json_encode($subs) }}" inline-template>

</sub-index>
@endsection
