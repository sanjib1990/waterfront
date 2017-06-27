/**
 * Created by sanjibdevnath on 27/6/17.
 */

let chai        = require("chai");
let chai_http   = require("chai-http");

chai.use(chai_http);

describe("Test", function () {
   it("should Do a simple test", function () {
       chai.expect(4+8).equal(12);
   });

    it("should Do another simple test", function () {
        chai.expect(4+8+1).equal(13);
    });
});