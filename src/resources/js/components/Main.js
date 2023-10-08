import React, { useEffect, useRef, useState } from 'react';
import ReactDOM from 'react-dom';
import AddItemContainer from './AddItemContainer';
import SearchContainer from './SearchContainer';
import RowItem from './RowItem';
import '../../sass/main.scss';

function Main() {
    const [books, setBooks] = useState(null);
    const query = useRef("");
    const sortBy = useRef(["", ""]);
    const [addWarning, setAddWarning] = useState("");

    useEffect(() => {
        async function prepare() {
            let res = await fetch("/api/books");
            if(res.status === 200) {
                let json = await res.json();
                setBooks(json.data ?? []);
            }
        }

        prepare();
    }, []);


    async function sendSortedSearchQuery() {
        let res = await fetch("/api/books/search?query=" + query.current + "&orderBy=" + sortBy.current[0] + "&order=" + sortBy.current[1]);
        let json = await res.json();
        setBooks(json?.data);
    }

    async function handleAddBook(book) {
        let res = await fetch("/api/books/add", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(book)
        });
        let json = await res.json();
        if(res.status === 200) {
            sendSortedSearchQuery();
        }
        else if(res.status >= 400) {
            setAddWarning(json.message);
        }
    }

    async function handleDeleteBook(id) {
        let res = await fetch("/api/books/" + id, {
            method: "delete",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        });
        if(res.status === 200) {
            sendSortedSearchQuery();
        }
    }

    function handleSearchChange(e) {
       query.current = e.target.value;
       sendSortedSearchQuery();
    }

    function handleSortChange(e) {
        let val = e.target.value.split("-");
        sortBy.current = val ? [val[0], val[1].toUpperCase()] : ["", ""];
        sendSortedSearchQuery();
    }


    return <div id="content-body">
        <AddItemContainer handleAddBook={handleAddBook} setAddWarning={setAddWarning}/>
        {addWarning ? <p id="warning-add">{addWarning}</p> : null}
        <SearchContainer handleSearchChange={handleSearchChange} handleSortChange={handleSortChange} />
        <table>
            <thead>
                <tr>
                    <th id='col-title'>Title</th>
                    <th id='col-author'>Author</th>
                    <th id='col-delete'>Delete</th>
                </tr>
            </thead>
            
            <tbody>
                {books ? books.map((b, i) => <RowItem key={b.title+"_" + i + "_"+b.author} book={b} handleDeleteBook={handleDeleteBook} />) : (query.current ? 
                    <div>No books matching "{query.current}" found</div>
                : null)}
            </tbody>
        </table>
    </div>;
}

export default Main;

if (document.getElementById('root')) {
    ReactDOM.render(<Main />, document.getElementById('root'));
}