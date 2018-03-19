@extends('layouts.base')

@if(have_posts())
	@while(have_posts()) @php(the_post())

	<article class="post-entry">
		<div class="post-entry__text">
			@php(the_content())
		</div>
	</article>

	@endwhile
@endif
