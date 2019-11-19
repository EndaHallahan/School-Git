import React, {Component} from 'react';
import {movies} from './movies';

import './styles.css';
import MoviePreview from './moviePreview';
import MovieInformation from './movieInformation';

class App extends Component {
    _setCurrentMovie = (movie) =>
        this.setState({
            currentMovie: movie
        });

    constructor(props) {
        super(props);

        this.setCurrentMovie = this._setCurrentMovie.bind(this);

        this.state = {
            currentMovie: null
        };
    }

    render() {
        return (
            <div>
                <MoviePreview
                    movies={movies}
                    setCurrentMovieFunction={this.setCurrentMovie}
                />
                <div>
                    {
                        this.state.currentMovie ?
                            <MovieInformation
                                currentMovie={this.state.currentMovie}
                                setCurrentMovieFunction={this.setCurrentMovie}
                            />
                            :
                            <div className="select-movie">
                                <p>Select a movie to see more information.</p>
                            </div>
                    }
                </div>
            </div>
        );
    }
}

export default App;
