
<div class="container">
    <div class="row-fluid">
        <div class="span4 well">
            <label style="width: 100%;" align="center" id="txtRegStatus">
            </label>
            <h3>
                Registre su extension
            </h3>
            <br />
            <table style='width: 100%'>
                <tr>
                    <td>
                        <label style="height: 100%">
                            Extension:
                        </label>
                    </td>
                    <td>
                        <input type="text" style="width: 100%; height: 100%" id="txtDisplayName" value=""
                               placeholder="e.g. John Doe" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label style="height: 100%">
                            Usuario:
                        </label>
                    </td>
                    <td>
                        <input type="text" style="width: 100%; height: 100%" id="txtPrivateIdentity" value=""
                               placeholder="e.g. +33600000000" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label style="height: 100%">
                            Registro:
                        </label>
                    </td>
                    <td>
                        <input type="text" style="width: 100%; height: 100%" id="txtPublicIdentity" value=""
                               placeholder="e.g. sip:+33600000000@doubango.org" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label style="height: 100%">Contraseña:</label>
                    </td>
                    <td>
                        <input type="password" style="width: 100%; height: 100%" id="txtPassword" value="" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label style="height: 100%">ServidorPbx:</label>
                    </td>
                    <td>
                        <input type="text" style="width: 100%; height: 100%" id="txtRealm" value="" placeholder="e.g. doubango.org" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <input type="button" class="btn btn-success" id="btnRegister" value="LogIn" disabled onclick='sipRegister();' />
                        &nbsp;
                        <input type="button" class="btn btn-danger" id="btnUnRegister" value="LogOut" disabled onclick='sipUnRegister();' />
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <a class="btn" href="./expert.htm" target="_blank">Avanzado</a>
                    </td>
                </tr>
            </table>
        </div>
        <div id="divCallCtrl" class="span7 well" style='display:table-cell; vertical-align:middle'>
            <label style="width: 100%;" align="center" id="txtCallStatus">
            </label>
            <h2>
                Marcador
            </h2>
            <br />
            <table style='width: 100%;'>
                <tr>
                    <td style="white-space:nowrap;">
                        <input type="text" style="width: 100%; height:100%;" id="txtPhoneNumber" value="" placeholder="Digite el numero" />
                    </td>
                </tr>
                <tr>
                    <td colspan="1" align="right">
                        <div class="btn-toolbar" style="margin: 0; vertical-align:middle">
                            <!--div class="btn-group">
                                <input type="button" id="btnBFCP" style="margin: 0; vertical-align:middle; height: 100%;" class="btn btn-primary" value="BFCP" onclick='sipShareScreen();' disabled />
                            </div-->
                            <div id="divBtnCallGroup" class="btn-group">
                                <button id="btnCall" disabled class="btn btn-primary" data-toggle="dropdown">Llamar</button>
                            </div>&nbsp;&nbsp;
                            <div class="btn-group">
                                <input type="button" id="btnHangUp" style="margin: 0; vertical-align:middle; height: 100%;" class="btn btn-primary" value="Colgar" onclick='sipHangUp();' disabled />
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td id="tdVideo" class='tab-video'>
                        <div id="divVideo" class='div-video'>
                            <div id="divVideoRemote" style='position:relative; border:1px solid #009; height:100%; width:100%; z-index: auto; opacity: 1'>
                                <video class="video" width="100%" height="100%" id="video_remote" autoplay="autoplay" style="opacity: 0;
                                       background-color: #000000; -webkit-transition-property: opacity; -webkit-transition-duration: 2s;"></video>
                            </div>

                            <div id="divVideoLocalWrapper" style="margin-left: 0px; border:0px solid #009; z-index: 1000">
                                <iframe class="previewvideo" style="border:0px solid #009; z-index: 1000"> </iframe>
                                <div id="divVideoLocal" class="previewvideo" style=' border:0px solid #009; z-index: 1000'>
                                    <video class="video" width="100%" height="100%" id="video_local" autoplay="autoplay" muted="true" style="opacity: 0;
                                           background-color: #000000; -webkit-transition-property: opacity;
                                           -webkit-transition-duration: 2s;"></video>
                                </div>
                            </div>
                            <div id="divScreencastLocalWrapper" style="margin-left: 90px; border:0px solid #009; z-index: 1000">
                                <iframe class="previewvideo" style="border:0px solid #009; z-index: 1000"> </iframe>
                                <div id="divScreencastLocal" class="previewvideo" style=' border:0px solid #009; z-index: 1000'>
                                </div>
                            </div>
                            <!--div id="div1" style="margin-left: 300px; border:0px solid #009; z-index: 1000">
                                <iframe class="previewvideo" style="border:0px solid #009; z-index: 1000"> </iframe>
                                <div id="div2" class="previewvideo" style='border:0px solid #009; z-index: 1000'>
                                  <input type="button" class="btn" style="" id="Button1" value="Button1" /> &nbsp;
                                  <input type="button" class="btn" style="" id="Button2" value="Button2" /> &nbsp;
                                </div>
                            </div-->
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align='center'>
                        <div id='divCallOptions' class='call-options' style='opacity: 0; margin-top: 0px'>
                            <input type="button" class="btn" style="" id="btnFullScreen" value="FullScreen" disabled onclick='toggleFullScreen();' /> &nbsp;
                            <input type="button" class="btn" style="" id="btnMute" value="Mute" onclick='sipToggleMute();' /> &nbsp;
                            <input type="button" class="btn" style="" id="btnHoldResume" value="Hold" onclick='sipToggleHoldResume();' /> &nbsp;
                            <input type="button" class="btn" style="" id="btnTransfer" value="Transferi" onclick='sipTransfer();' /> &nbsp;
                            <input type="button" class="btn" style="" id="btnKeyPad" value="KeyPad" onclick='openKeyPad();' />
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <br />
    <footer>


        <!-- Creates all ATL/COM objects right now
            Will open confirmation dialogs if not already done
        -->
        <!--object id="fakeVideoDisplay" classid="clsid:5C2C407B-09D9-449B-BB83-C39B7802A684" style="visibility:hidden;"> </object-->
        <!--object id="fakeLooper" classid="clsid:7082C446-54A8-4280-A18D-54143846211A" style="visibility:visible; width:0px; height:0px"> </object-->
        <!--object id="fakeSessionDescription" classid="clsid:DBA9F8E2-F9FB-47CF-8797-986A69A1CA9C" style="visibility:hidden;"> </object-->
        <!--object id="fakeNetTransport" classid="clsid:5A7D84EC-382C-4844-AB3A-9825DBE30DAE" style="visibility:hidden;"> </object-->
        <!--object id="fakePeerConnection" classid="clsid:56D10AD3-8F52-4AA4-854B-41F4D6F9CEA3" style="visibility:hidden;"> </object-->
        <object id="fakePluginInstance" classid="clsid:69E4A9D1-824C-40DA-9680-C7424A27B6A0" style="visibility:hidden;"> </object>

        <!--
            NPAPI  browsers: Safari, Opera and Firefox
        -->
        <!--embed id="WebRtc4npapi" type="application/w4a" width='1' height='1' style='visibility:hidden;' /-->
    </footer>
</div>
<!-- /container -->
<!-- Glass Panel -->
<div id='divGlassPanel' class='glass-panel' style='visibility:hidden'></div>
<!-- KeyPad Div -->
<div id='divKeyPad' class='span2 well div-keypad' style="left:0px; top:0px; width:250; height:240; visibility:hidden">
    <table style="width: 100%; height: 100%">
        <tr><td><input type="button" style="width: 33%" class="btn" value="1" onclick="sipSendDTMF('1');" /><input type="button" style="width: 33%" class="btn" value="2" onclick="sipSendDTMF('2');" /><input type="button" style="width: 33%" class="btn" value="3" onclick="sipSendDTMF('3');" /></td></tr>
        <tr><td><input type="button" style="width: 33%" class="btn" value="4" onclick="sipSendDTMF('4');" /><input type="button" style="width: 33%" class="btn" value="5" onclick="sipSendDTMF('5');" /><input type="button" style="width: 33%" class="btn" value="6" onclick="sipSendDTMF('6');" /></td></tr>
        <tr><td><input type="button" style="width: 33%" class="btn" value="7" onclick="sipSendDTMF('7');" /><input type="button" style="width: 33%" class="btn" value="8" onclick="sipSendDTMF('8');" /><input type="button" style="width: 33%" class="btn" value="9" onclick="sipSendDTMF('9');" /></td></tr>
        <tr><td><input type="button" style="width: 33%" class="btn" value="*" onclick="sipSendDTMF('*');" /><input type="button" style="width: 33%" class="btn" value="0" onclick="sipSendDTMF('0');" /><input type="button" style="width: 33%" class="btn" value="#" onclick="sipSendDTMF('#');" /></td></tr>
        <tr><td colspan=3><input type="button" style="width: 100%" class="btn btn-medium btn-danger" value="close" onclick="closeKeyPad();" /></td></tr>
    </table>
</div>
<!-- Call button options -->
<ul id="ulCallOptions" class="dropdown-menu" style="visibility:hidden">
    <li><a href="#" onclick='sipCall("call-audio");'>Audio</a></li>
    <li><a href="#" onclick='sipCall("call-audiovideo");'>Video</a></li>
    <li id='liScreenShare'><a href="#" onclick='sipShareScreen();'>Screen Share</a></li>
    <li class="divider"></li>
    <li><a href="#" onclick='uiDisableCallOptions();'><b>Disable these options</b></a></li>
</ul>
