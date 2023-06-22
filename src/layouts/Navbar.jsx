const Navbar = ({title, buttonOne, buttonTwo}) => {
    return ( <div className="navbar">
        <h1 className="navbar-title">{title}</h1>
        <div className="buttons-holder">
            <button className="navbar-button" onClick={buttonOne.func} style={{backgroundColor:buttonOne.color}}>
                    {buttonOne.label}
            </button>
            <button 
                className="navbar-button" 
                onClick={buttonTwo.func} style={{backgroundColor:buttonTwo.color}}>
                    {buttonTwo.label}
            </button>
        </div>
    </div> );
}
 
export default Navbar;