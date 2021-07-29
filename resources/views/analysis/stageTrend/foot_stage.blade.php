<div>
  <span class="stage" data-option="latent"></span>
  <p class="c-count" data-ttl="査定・商談">{{$data['latent']['AssessmentCount']}}</p>
  <p class="c-count" data-ttl="再商談">{{$data['latent']['ReNegotiationCount']}}</p>
  <span class="stage" data-option="overt"></span>
  <p class="c-count" data-ttl="査定・商談">{{$data['overt']['AssessmentCount']}}</p>
  <p class="c-count" data-ttl="再商談">{{$data['overt']['ReNegotiationCount']}}</p>
  <span class="stage" data-option="mediation"></span>
  <p class="c-count" data-ttl="専任">{{$data['mediation']['DedicatedIntermediaryCount']}}</p>
  <p class="c-count" data-ttl="売主">{{$data['mediation']['SellerCount']}}</p>
  <p class="c-count" data-ttl="一般">{{$data['mediation']['panpyCount']}}</p>
  <p class="c-count" data-ttl="専属">{{$data['mediation']['ExclusiveCount']}}</p>
</div>