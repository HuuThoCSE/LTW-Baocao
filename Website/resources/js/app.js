import './bootstrap';

// import Web3 from 'web3';

import web3 from "./fabric";


// const web3 = new Web3(Web3.givenProvider || 'http://localhost:8545');

// // Ví dụ: Lấy danh sách tài khoản
// web3.eth.getAccounts()
//     .then(accounts => {
//         console.log(accounts);
//     })
//     .catch(error => {
//         console.error(error);
//     });

async function getAccountBalance(accountAddress) {
  const balance = await web3.eth.getBalance(accountAddress);
  console.log("Account balance:", web3.utils.fromWei(balance, "ether"), "ETH");
}