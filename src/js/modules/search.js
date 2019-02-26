import { timeout } from "q";
import { isNumber } from "util";

// import $ from 'jquery';

class Search {

    constructor() {

        this.searchField = document.querySelector( '.pbp-live-search--container input' );
        this.searchButton = document.querySelector( '#pbp-search--icon' );
        this.searchResultContainer = document.querySelector( '.pbp-search--result__container .result-content' );
        this.setTimer;
        this.previousValue;
        this.outputResults = '';
        this.searchButtonTriggered = false;
        this.events();
        
    }

    // Events
    events() {

        this.searchButton.addEventListener( 'click', this.buttonClikedDispatcher.bind(this) );
        this.searchField.addEventListener( 'keyup', this.keyPressDispatcher.bind(this) );
        
    }

    // Methods
    // buttonClikedDispatcher = async ( e ) => {
    buttonClikedDispatcher( e ) {
        if( e.target == this.searchButton ) {
            this.searchButtonTriggered = true;
            this.getResults();
            // this.searchField.value = '';
        }
    }

    keyPressDispatcher() {

        if( !this.searchButtonTriggered ) {

            if( this.searchField.value !== this.previousValue ) {
                clearTimeout( this.setTimer );
                this.setTimer = setTimeout( () => {
                    this.getResults();
                    // this.searchField.value = '';
                }, 2000 );
            }

        }

    }

    getResults() {

        fetch( 'http://pubsbarsplugin.local/wp-json/pubs-bars-plugin/v1/bars/' + this.searchField.value )
        .then( res => res.json() )
        .then( data => {

                if ( data ) {

                    if( data.length > 1 || data.length !== undefined ) {
                        data.map( item => {
                            this.outputResults += `
                            <div class="result-content--item">
                                <h3><a href="#" target="_blank" role="bookmark">${item.name}</a></h3>
                                <p>${item.city}</p>
                            </div>
                            `;
                        } );
                    }
                    else {
                        this.outputResults += `
                            <div class="result-content--item">
                                <h3><a href="#" target="_blank" role="bookmark">${data.name}</a></h3>
                                <p>${data.city}</p>
                            </div>
                        `;
                    }

                }else{
                    this.outputResults = '<p>No Results Found!</p>';
                }

                // Ouputting the Result of Live Search
                if( this.searchField.value !== '' ){
                    this.searchResultContainer.innerHTML = `<h2>Search Result(s) For: "${this.searchField.value}".</h2><hr>${this.outputResults}`;
                    // this.searchField.setAttribute( 'placeholder', this.searchField.value );
                }else{
                    this.searchResultContainer.innerHTML = '';
                }
                
                // Storing search field value
                this.previousValue = this.searchField.value;

                // this.searchField.value = '';

            } )
            .catch( err => console.error(err) );

    }


}

export default Search;