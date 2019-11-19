import React, {Component} from 'react';

class MoviePreview extends Component {
    render() {
        const {
            movies,
            setCurrentMovieFunction
        } = this.props;

        return (
            <div className="movie-previews">
                {
                    movies.map((movie) =>
                        <button
                            className="preview-button"
                            key={movie.title}
                            onClick={() => setCurrentMovieFunction(movie)}
                        >
                            <p>{movie.title}</p>
                            <p>{movie.rating}</p>
                            <p>{movie.releaseYear}</p>
                            <img
                                alt={movie.title}
                                src={movie.posterUrl}
                                height={250}
                            />
                        </button>
                    )
                }
            </div>
        );
    }
}

export default MoviePreview;
