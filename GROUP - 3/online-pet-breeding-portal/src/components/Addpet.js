import React from "react";
import uuid from "uuid";
import './Addpet.css'
import DateComp from './DateComp'

class Addpet extends React.Component {
  state = {
    items: [{ id: uuid(), text: "" }],
    clear: "",
    gendPos: false,
  };

  addListItem = () => {
    if (!(this.state.items.length >= 10)) {
      const newItem = { id: uuid(), text: "" };
      this.setState({
        items: [...this.state.items, newItem]
      });
    }
  };
  delItem = (e) => {
    const i = this.state.items.map(function (a) { return a.id });
    const ind = i.indexOf(e.target.value);
    if (!(this.state.items.length === 1)) {
      if (ind > -1) {
        this.state.items.splice(ind, 1);
        this.setState({ clear: e.target.value })
      }
    }
  }
  onInputChange = e => {
    const { id, value } = e.target;
    const newArr = this.state.items.map(item => {
      if (item.id === id) {
        return {
          ...item,
          text: value
        };
      } else {
        return item;
      }
    });

    this.setState({
      items: newArr
    });
  }

  handlegend() {
    this.setState({ gendPos: true });
  }
  handleSlt(e) {
    if (e.target.value === "") {
      this.setState({ gendPos: false });
    }
  }

  createList = () => {
    const { items } = this.state;
    return items.map((item, index) => {
      const inde = index + 1;
      return (
        <form className='regForm' key={inde}>
          <h2 className='formHead' style={{ marginBottom: "-4.5vh" }}>Pet {inde} Information</h2>
          <div className='regForm-wrapper'>
            <div className='col1 petAddDiv' key={item.id}>
              <div className="field col2a">
                <input type="text" name={'pName' + inde} id={'pName' + inde} className='login' placeholder="Pet Name" />
                <label id={'LRPName' + inde} className='label-log' htmlFor={'pName' + inde}>Pet Name <p style={{ color: "red" }}>*</p></label>
              </div>
              <div className="field col2b">
                <DateComp used='reg' strDate={new Date()} classN='margiNFIx' DATname={'regDates' + inde} DATid={'regDates' + inde} laDatname="regDate" laDatVal="Birth Date" />
              </div>
              <div className="field col2a">
                <select id='regGend' name='regGend' onClick={() => { this.handlegend() }} onBlur={(e) => { this.handleSlt(e) }} className={this.state.gendPos ? 'regSlt gendAct' : 'regSlt '} defaultValue=''>
                  <option value='' disabled></option>
                  <option value='Male'>Male</option>
                  <option value='Neutered Male'>Neutered Male</option>
                  <option value='Female'>Female</option>
                  <option value='Spayed Female'>Spayed Female</option>
                </select>
                <label id='LRgend' className={this.state.gendPos ? 'label-log gendMove' : 'label-log gend'} htmlFor="regGend">Gender</label>
              </div>

              <div className="field col2a">
                <input type="text" name={'pSpec' + inde} id={'pSpec' + inde} className='login' placeholder="Species" />
                <label id={'LRSpec' + inde} className='label-log' htmlFor={'pSpec' + inde}>Species <p style={{ color: "red" }}>*</p></label>
              </div>
              <div className="field col2a">
                <input type="text" name={'pBreed' + inde} id={'pBreed' + inde} className='login' placeholder="Breed" />
                <label id={'LRBreed' + inde} className='label-log' htmlFor={'pBreed' + inde}>Breed <p style={{ color: "red" }}>*</p></label>
              </div>

            </div>
            <button className='col1 btn-log' id='petDel' type='button' value={item.id} onClick={(e) => { this.delItem(e) }}>Delete</button>
          </div>
        </form>
      );
    });
  };
  handleSign() {

  }
  render() {
    return (
      <>
        {this.createList()}

        <div className='petBTrt'>
          <button className='btn-log ApetBtn' type='button' onClick={this.addListItem}>Add Pet</button>
          <button type='button' className='btn-log ApetBtn' onClick={() => { this.handleSign() }}>Sign In</button>
        </div>
      </>
    );
  }
}

export default Addpet