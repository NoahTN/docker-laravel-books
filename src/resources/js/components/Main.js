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
    const [message, setMessage] = useState("Fetching books...");

    useEffect(() => {
        async function prepare() {
            let res = await fetch("/api/books");
            let json = await res.json();
            if(res.status === 200) {
                setBooks(json?.data || []);
                setMessage("");
            }
            else {
                setMessage(res.message);
            }
        }

        prepare();
    }, []);


    async function sendSortedSearchQuery() {
        let onlyMessage = false;
        if(!message) {
            setMessage("Fetching books...");
            onlyMessage = true;
        }
        let res = await fetch("/api/books/search?query=" + query.current + "&orderBy=" + sortBy.current[0] + "&order=" + sortBy.current[1]);
        let json = await res.json();
        setBooks(json?.data);

        setMessage("");
    }

    async function handleAddBook(book) {
        setMessage("Adding book...");
        let res = await fetch("/api/books/add", {
            method: "post",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(book)
        });
        let json = await res.json();
        if(res.status === 200) {
            await sendSortedSearchQuery();
        }
        else if(res.status >= 400) {
            setMessage(json.message);
        }
    }

    async function handleDeleteBook(id) {
        setMessage("Deleting book...");
        let res = await fetch("/api/books/" + id, {
            method: "delete",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        });
        let json = await res.json();
        if(res.status === 200) {
            await sendSortedSearchQuery();
        }
        else {
            setMessage(json.message);
        }
    }

    async function handleSearchChange(e) {
       query.current = e.target.value;
       await sendSortedSearchQuery();
    }

    async function handleSortChange(e) {
        let val = e.target.value.split("-");
        sortBy.current = val ? [val[0], val[1].toUpperCase()] : ["", ""];
        await sendSortedSearchQuery();
    }

    async function handleUpdateAuthor(id, value) {
        setMessage("Updating author...");
        let res = await fetch("/api/books/author", {
            method: "put",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({id: id, new_author: value})
        });
        let json = await res.json();
        if(res.status === 200) {
            await sendSortedSearchQuery();
        }
        else {
            setMessage(json.message);
        }
    }


    return <div id="content-body">
        <AddItemContainer handleAddBook={handleAddBook} setMessage={setMessage}/>
        {message ? <p id="message">{message}</p> : null}
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
                {books ? books.map((b, i) => <RowItem key={b.title+"_" + i + "_"+b.author} book={b} handleDeleteBook={handleDeleteBook} handleUpdateAuthor={handleUpdateAuthor} />) : (query.current ? 
                    <tr><td>No books matching "{query.current}" found</td></tr>
                : null)}
            </tbody>
        </table>
    </div>;
}

export default Main;

if (document.getElementById('root')) {
    ReactDOM.render(<Main />, document.getElementById('root'));
}