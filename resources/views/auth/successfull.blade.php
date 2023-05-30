@extends('frontend.layout.main')
@section('content')
    <section>
		<div class="tr-register">
			<div class="tr-regi-form">
                    <div>
                        @forelse(['danger', 'warning', 'success', 'info'] as $msg)
                            @if (Session::has($msg) )
                                <div class="demo-spacing-0">
                                    <div class="alert alert-{{$msg}} mt-1 alert-validation-msg" role="alert">
                                        <div class="alert-body">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info mr-50 align-middle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                            <p>{{ Session::get($msg) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                <p>
                 Vous êtes déjà membre ?<a href="{{ route('user.index') }}"> Se connecter</a>
				</p>
			</div>
		</div>
	</section>
@endsection

