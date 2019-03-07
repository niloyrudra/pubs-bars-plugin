import { error } from "util";

// import $ from 'jquery';

class LiveSearch {

    constructor() {
        
        this.searchResultContainer = document.querySelector( 'div#content.site-content #primary.content-area' );
        this.searchResultContainerTwo = document.querySelector( '.pbp-site-content .content-area' );
        this.pageHeaderTitle = document.querySelector( '.page-header h1.page-title span' );
        this.pageHeaderTitleTwo = document.querySelector( '.pbp-site-content .page-header h1.page-title span' );
        this.searchField = document.querySelector( 'input[name="s"]' );
        this.searchForm = document.querySelector( 'form.search-form' );

        this.jsonData = [];
        this.formSubmitted = false;
        this.previousValue;
        
        this.events();

    }

    events() {

        if( this.searchForm ) {
            this.searchField.addEventListener( 'keyup', this.keyPressDispatcher.bind(this) );
        }
        
    }


    keyPressDispatcher() {

        if( this.searchField.value !== this.previousValue ) {
            clearTimeout( this.setTimer );
            this.searchResultContainer.innerHTML = '';
            this.setTimer = setTimeout( () => this.getResults(), 750 );
        }

    }

    getResults() {

        let RestURL = barsData.root_url + '/wp-json/bars/v1/search?term=' + this.searchField.value;

        if( this.searchField.value == '' ) {
            return;
        }

        fetch( RestURL )
            .then( res => res.json() )
            .then( data => {

                let outputResults = '';

                if( data.bars.length ) {

                    outputResults += data.bars.map( item => `<h3 class="entry-title"><a href="${item.permalink}" target="_blank" role="bookmark">${item.title}</a></h3><p>${item.content}</p><hr>` ).join('');

                }
                else {
                    outputResults += `<h4 style="font-size:14px;color:red;">No Related Pubs/Bars Found!</h4>`;
                }

                
                if( this.searchResultContainer ) {

                    // Ouputting the Result of Live Search
                    if( this.searchField.value != '' ){
                        this.pageHeaderTitle.innerHTML = this.searchField.value;
                        this.searchResultContainer.innerHTML = outputResults;
                        // this.searchField.setAttribute( 'placeholder', this.searchField.value );
                    }else{
                        this.pageHeaderTitle.innerHTML = '';
                        this.searchResultContainer.innerHTML = '';
                    }

                }else {

                    // Ouputting the Result of Live Search
                    if( this.searchField.value != '' ){
                        this.pageHeaderTitleTwo.innerHTML = this.searchField.value;
                        this.searchResultContainerTwo.innerHTML = outputResults;
                        // this.searchField.setAttribute( 'placeholder', this.searchField.value );
                    }else{
                        this.pageHeaderTitleTwo.innerHTML = '';
                        this.searchResultContainerTwo.innerHTML = '';
                    }

                }

                // Storing search field value
                this.previousValue = this.searchField.value;

            } )
            .catch( err => console.log(err) );

    }

}

export default LiveSearch;