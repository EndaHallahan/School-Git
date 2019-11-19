import React, {Component} from 'react';

class MovieInformation extends Component {
    render() {
        const {
            currentMovie,
            setCurrentMovieFunction
        } = this.props;

        return (
            <div className="movie-information">
                <button
                    className="close-button"
                    key={"Close"}
                    onClick={() => setCurrentMovieFunction(null)}
                >X</button>
                <div>
                    <img
                        alt={currentMovie.title}
                        className="poster-image"
                        src={currentMovie.posterUrl}
                        width={350}
                    />
                </div>
                <div className="movie-text">
                    <p className="movie-title">{currentMovie.title}</p>
                    <p>Release Year: {currentMovie.releaseYear}</p>
                    <p>Director: {currentMovie.director}</p>
                    <p>Categories: {currentMovie.categories.join(',')}</p>
                    <p>Description: {currentMovie.description}</p>
                    <p>Rating: {currentMovie.rating}/10</p>
                </div>
            </div>
        );
    }
}

export default MovieInformation;
