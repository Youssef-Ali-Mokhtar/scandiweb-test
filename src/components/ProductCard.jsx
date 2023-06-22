import { useState } from "react";

const ProductCard = ({ specs, handleDeletedCards }) => {

    const [isChecked, setIsChecked] = useState(false);

    const handleCheck = (e)=>{
        setIsChecked(prev=>!prev);
        handleDeletedCards(specs.sku, e.target.checked);
    }

    return ( <div className='product-card'>
                <div className="delete-checkbox-holder">
                    <input
                        className="delete-checkbox"
                        type="checkbox"
                        checked={isChecked}
                        onChange={handleCheck}
                    />
                </div>
                <p>{specs.sku}</p>
                <p>{specs.name}</p>
                <p>{`${(+specs.price).toFixed(2)} $`}</p>
                {specs.product_type==="DVD"&&(
                        <div style={{display:'flex'}}>
                            <p>Size: </p>
                            <p>{specs.size} MB</p>
                        </div>
                )}
                {specs.product_type==="Book"&&(
                        <div style={{display:'flex'}}>
                            <p>Weight: </p>
                            <p>{specs.weight} KG</p>
                        </div>
                )}
                {specs.product_type==="Furniture"&&(
                    <div style={{display:'flex'}}>
                        <p>Dimensions: </p>
                        <p>{specs.height}x
                            {specs.width}x
                            {specs.length}
                        </p>
                    </div>

                    )
                }
    </div> );
}
 
export default ProductCard;