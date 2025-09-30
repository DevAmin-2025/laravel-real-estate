@isset($user)
    <p>Please click on the following link to complete your registration:</p>
    <a href="{{ route('user.register.verify', $token)}}">Verify Email</a>
@endisset

@isset($agent)
    <p>Please click on the following link to complete your registration:</p>
    <a href="{{ route('agent.register.verify', $token)}}">Verify Email</a>
@endisset
