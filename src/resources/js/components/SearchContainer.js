import React from 'react';
import '../../sass/searchContainer.scss';

function SearchContainer(props) {
    return <div id="search-container">
        <input name="query" onChange={props.handleSearchChange}/>
        <select onChange={props.handleSortChange}>
            <option value="none" defaultValue>Sort by</option>
            <option value="title-asc">Title, ASC</option>
            <option value="title-desc">Title, DESC</option>
            <option value="author-asc">Author, ASC</option>
            <option value="author-desc">Author, DESC</option>
        </select>
    </div>;
}

export default SearchContainer;