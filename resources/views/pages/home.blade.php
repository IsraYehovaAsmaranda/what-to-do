@extends('layout')

@section('title', 'What To Do - Share Your Activity Ideas')

@section('content')
    @include('components.alert')
    <!-- Hero Section -->
    <section class="text-center bg-light py-5">
        <div class="container">
            <h1 class="display-4">What To Do?</h1>
            <p class="lead">Explore new activities to do and share your ideas with the world!</p>
            <a href="/postidea" class="btn btn-primary btn-lg">Post Your Idea</a>
        </div>
    </section>

    <!-- Ideas Section -->
    <section class="my-5">
        <h2 class="text-center mb-4">Here are the ideas of what you can do</h2>
        <div class="text-center mb-4">
            <a href="{{route('home', ['sort' => 'most_recent'])}}" class="btn btn-outline-primary {{$sort == 'most_recent' ? 'active' : ''}}">Sort by Most Recent</a>
            <a href="{{route('home', ['sort' => 'most_rated'])}}" class="btn btn-outline-primary {{$sort == 'most_rated' ? 'active' : ''}}">Sort by Most Rated</a>
        </div>
        <div class="row">
            <!-- Idea Card 1 -->
            @foreach ($ideas as $idea)
                <div class="mb-3 col-md-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h5 class="card-title">{{ $idea->title }}</h5>
                            <p class="card-text">{{ $idea->description }}
                            </p>
                        </div>
                        <div class="card-footer text-center">
                            <p class="text-warning">⭐: {{ $idea->average_rating }}/5 ({{ $idea->ratings_count }} Ratings)
                            </p>
                            @if (Auth::check())
                                <button class="btn btn-outline-success" data-bs-target="#rateIdea" data-bs-toggle="modal"
                                    onclick="openRatingModal({{ $idea->id }})">Rate</button>
                            @else
                            <a href="/login" class="btn btn-outline-success">Login to rate</a>
                            @endif
                            @if ($idea->user_id == Auth::id())
                                <button id="deleteIdeaButton" class="btn btn-outline-danger"
                                    onclick="openDeleteModal({{ $idea->id }})" data-bs-toggle="modal"
                                    data-bs-target="#deleteIdea">Delete</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
        {{ $ideas->links() }}
    </section>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteIdea" tabindex="-1" aria-labelledby="deleteIdeaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteIdeaModalLabel">Delete Idea</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this idea?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form id="deleteIdeaForm" action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Idea</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rateIdea" tabindex="-1" aria-labelledby="rateIdeaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="rateIdeaModalLabel">Rate Idea</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rateIdeaForm" action="/rate" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="container text-center">
                            <input type="text" name="ideaId" id="ideaId">
                            <div class="rating">
                                <span class="star" id="star-1" data-value="1">&#9733;</span>
                                <span class="star" id="star-2" data-value="2">&#9733;</span>
                                <span class="star" id="star-3" data-value="3">&#9733;</span>
                                <span class="star" id="star-4" data-value="4">&#9733;</span>
                                <span class="star" id="star-5" data-value="5">&#9733;</span>
                            </div>
                            <input type="hidden" id="ratingValue" name="rating" value="0" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Rate Idea</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(id) {
            // Set action form dengan ID yang diterima
            document.getElementById('deleteIdeaForm').action = '/ideas/' + id;
        }

        function openRatingModal(id) {
            // Reset Input
            $('#ideaId').val('');
            $('.star').removeClass('selected');

            $('#ideaId').val(id);
        }

        $(document).ready(function() {
            $('.star').on('click', function() {
                const rating = $(this).data('value');
                $('#ratingValue').val(rating);

                // Reset semua bintang
                $('.star').removeClass('selected');

                // Highlight bintang yang dipilih
                for (let i = 1; i <= rating; i++) {
                    $(`#star-${i}`).addClass('selected');
                }
            });

            $('.star').hover(
                function() {
                    const rating = $(this).data('value');
                    console.log(rating);
                    $('.star').removeClass('selected');
                    for (let i = 1; i <= rating; i++) {
                        console.log(i);
                        $(`#star-${i}`).addClass('selected');
                    }
                },
                function() {
                    const currentRating = $('#ratingValue').val();
                    $('.star').removeClass('selected');
                    for (let i = 1; i <= currentRating; i++) {
                        console.log(i);
                        $(`#star-${i}`).addClass('selected');
                    }
                }
            );
        });
    </script>
@endsection
