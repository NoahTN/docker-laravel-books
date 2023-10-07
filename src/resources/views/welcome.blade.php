<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            #form-add {
                display: flex;
                flex-direction: row;
            }

            .input-container {
                display: flex;
                flex-direction: row;
            }

            .required-field::after {
                content: "*";
                color: red;
            }

            tr {
               
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>
                <div>
                    <input />
                    <select>
                        <option value="none" selected>Sort by</option>
                        <option value="title-asc">Title, ASC</option>
                        <option value="title-desc">Title, DESC</option>
                        <option value="author-asc">Author, ASC</option>
                        <option value="author-desc">Author, DESC</option>
                    </select>
                </div>

                <form id="form-add">
                    @csrf
                    <div class="input-container">
                        <label for="title" class="required-field">Title</label>
                        <input required name="title" title="A title is required"/>
                    </div>
                    <div class="input-container">
                        <label for="author" class="required-field">Author</label>
                        <input required name="author" title="An author is required"/>
                    <button id="add-book">Add Book</button>
                    <script type="text/javascript">
                        document.getElementById("add-book").addEventListener('click', async () => {
                            let res = await fetch("/api/books/add", {
                                method: "POST",
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                }
                            });
                        });
                    </script>
                    </div>
                </form>

                <table>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Delete</th>
                    </tr>
                    @foreach($books as $book)
                        @component('components.row-item', ['title' => $book->title, 'author' => $book->author])
                        @endcomponent
                    @endforeach
                </table>
        </div>
    </body>
</html>
