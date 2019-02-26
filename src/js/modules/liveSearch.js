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
            this.searchForm.addEventListener( 'submit', this.renderSearchResults.bind(this) );
        }
        
    }

    renderSearchResults( event )
    {
        this.formSubmitted = true;
        this.getResults();

        // if( this.jsonData ) {

        //     let output;

        //     if( this.jsonData.length > 1 ) {
        //         for( let i = 0; i < this.jsonData.length -1; i++ ) {
        //             output +=`<h3 class="entry-title"><a href="${this.jsonData[i].permalink}" target="_blank" role="bookmark">${this.jsonData[i].title}</a></h3><p>${this.jsonData[i].content}</p>`;
        //         }
        //         // this.jsonData.map( bars => {
        //         //     output +=`
        //         //         ${bars.map( item => `
        //         //                 <h3 class="entry-title"><a href="${item.permalink}" target="_blank" role="bookmark">${item.title}</a></h3>
        //         //                 <p>${item.content}</p>
        //         //         ` )}
        //         //     `;
        //         // } );

        //     }else{

        //         output +=`<h3 class="entry-title"><a href="${this.jsonData.permalink}" target="_blank" role="bookmark">${this.jsonData.title}</a></h3><p>${this.jsonData.content}</p>`;
        //     }


        //     if( this.searchResultContainer ) {
        //         if( this.searchField.value != '' ){
        //             this.pageHeaderTitle.innerHTML = this.searchField.value;
        //             this.searchResultContainer.innerHTML = output;
        //         }else{
        //             this.pageHeaderTitle.innerHTML = '';
        //             this.searchResultContainer.innerHTML = '';
        //         }

        //     }


        // }


    }

    keyPressDispatcher() {

        // if( !this.formSubmitted ) {
            if( this.searchField.value !== this.previousValue ) {
                clearTimeout( this.setTimer );
                this.searchResultContainer.innerHTML = '';
                this.setTimer = setTimeout( () => this.getResults(), 1200 );
            }

        // }


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

                    // this.jsonData.push(data.bars);
                    // this.jsonData = data.bars;

                    outputResults +=`
                        ${data.bars.map( item => `<h3 class="entry-title"><a href="${item.permalink}" target="_blank" role="bookmark">${item.title}</a></h3><p>${item.content}</p>` )}
                    `;

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