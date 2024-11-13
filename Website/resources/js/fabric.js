import Web3 from "web3";

// Địa chỉ EVM trên Hyperledger Fabric
const evmProviderUrl = "http://localhost:8545"; // Thay đổi URL theo cài đặt của bạn

const web3 = new Web3(new Web3.providers.HttpProvider(evmProviderUrl));

export default web3;